@component('mail::message')
# {{ $email['title'] }}

{{ $email['body'] }}

<br>
{{ $email['sender'] }}
@endcomponent
