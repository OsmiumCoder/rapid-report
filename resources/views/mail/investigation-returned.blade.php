<x-mail::message>
# Investigation Returned

{!! $message !!}

<x-mail::button :url="$url">
View Investigation
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
