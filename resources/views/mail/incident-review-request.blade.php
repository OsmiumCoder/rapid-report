<x-mail::message>
# Incident Follow Up Review Request

Your review has been requested on the below incident and its follow up.

<x-mail::button :url="$url">
View Incident
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
