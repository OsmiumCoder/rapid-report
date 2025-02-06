import { Incident } from '@/types/incident/Incident';
import { BadgeColor } from '@/Components/Badge';
import { IncidentStatus } from '@/Enums/IncidentStatus';

export function incidentBadgeColor(incident: Incident): BadgeColor {
    return incident.status === IncidentStatus.OPENED
        ? 'blue'
        : incident.status === IncidentStatus.ASSIGNED
          ? 'yellow'
          : incident.status === IncidentStatus.IN_REVIEW
            ? 'purple'
            : incident.status === IncidentStatus.CLOSED
              ? 'green'
              : 'red';
}
