<x-mail::message>
# Comment Created

## {{ $commenter }} has commented the following on incident #{{$incidentSlug}}:

{{ $content }}

<x-mail::button :url="$url">
View Incident
</x-mail::button>

Best regards,
UPEI Health, Safety, and Environment
</x-mail::message>
