<x-mail::message>
# New Contact Inquiry

**From:** {{ $inquiry->name }}
**Email:** {{ $inquiry->email }}
**Subject:** {{ $inquiry->subject }}

---

{{ $inquiry->message }}

---

<x-mail::button :url="config('app.url') . '/admin/messages/' . $inquiry->id">
View in Dashboard
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
