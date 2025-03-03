<x-mail::message>
# Incident Additional Information Added

## Incident #{{$incidentSlug}} has had the following information added:

{{$additionalInformation}}

<x-mail::button :url="$url">
    View Incident
</x-mail::button>

Thanks,<br>
UPEI Health, Safety, and Environment
</x-mail::message>
