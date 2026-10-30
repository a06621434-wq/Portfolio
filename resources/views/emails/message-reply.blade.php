<x-mail::message>
# Hello {{ $originalMessage->name }},

{!! nl2br(e($replyBody)) !!}

<x-mail::panel>
**In response to your inquiry regarding:** "{{ $originalMessage->subject }}"  
*Submitted on {{ $originalMessage->created_at->format('M d, Y h:i A') }}*

_{!! nl2br(e($originalMessage->message)) !!}_
</x-mail::panel>

If you have further questions or would like to arrange a direct consultation, feel free to reply directly to this email or reach us on WhatsApp at [+92 310 5447307](https://wa.me/923105447307?text={{ urlencode('Hi Shahzad, I received your email reply and would like to continue our discussion here.') }}).

Best regards,  
**{{ $senderName }}**  
[Shahzad Labs Portfolio]({{ config('app.url') }})
</x-mail::message>
