<?php

namespace Tests\Feature;

use App\Jobs\SendReplyEmailJob;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class MessageReplyQueueTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_reply_to_message_and_dispatch_queue_job(): void
    {
        Queue::fake();

        $admin = User::factory()->create();
        $message = Message::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Project inquiry',
            'message' => 'Hello, I need a website.',
        ]);

        $response = $this->actingAs($admin)->postJson(route('admin.messages.reply', $message), [
            'subject' => 'Re: Project inquiry',
            'reply_body' => 'Thank you for reaching out! We can definitely help.',
        ]);

        $response->assertOk();
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertDatabaseHas('message_replies', [
            'message_id' => $message->id,
            'subject' => 'Re: Project inquiry',
        ]);

        $this->assertTrue($message->fresh()->is_read);
        $this->assertNotNull($message->fresh()->replied_at);

        Queue::assertPushed(SendReplyEmailJob::class, function ($job) use ($message) {
            return $job->originalMessage->id === $message->id;
        });
    }

    public function test_admin_can_trigger_queue_worker(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->postJson(route('admin.queue.process'));

        $response->assertOk();
        $response->assertJsonStructure([
            'success',
            'message',
            'pending',
            'failed',
        ]);
    }

    public function test_cron_process_queue_requires_valid_token(): void
    {
        $unauthorized = $this->getJson(route('cron.queue', ['token' => 'invalid-token']));
        $unauthorized->assertStatus(403);

        $valid = $this->getJson(route('cron.queue', ['token' => env('CRON_TOKEN', 'shahzadlabs-queue-sync')]));
        $valid->assertOk();
        $valid->assertJsonStructure([
            'status',
            'time',
            'pending',
            'failed',
        ]);
    }
}

