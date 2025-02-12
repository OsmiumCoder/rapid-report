<x-mail::message>
# Investigation Submitted

An investigation was submitted. Click below to view the investigation that was submitted.

<x-mail::button :url="$url">
View Investigation
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
