<x-mail::message>
# Incident Assigned

{{$supervisorName}}, you have been assigned to review the following incident by {{$adminName}}.

Please submit an investigation within 24 hours and root cause analysis within 72 hours by visiting the following link:

<x-mail::button :url="$url">
View Incident
</x-mail::button>

Thanks,<br>
UPEI Health, Safety, and Environment
</x-mail::message>
