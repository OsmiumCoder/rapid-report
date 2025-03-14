<?php

namespace App\Enum;

enum NotificationMessageType: string
{
    case INCIDENT_RECEIVED = 'incident-received';
    case INCIDENT_SUBMITTED = 'incident-submitted';
    case INCIDENT_ASSIGNED = 'incident-assigned';
    case INCIDENT_REVIEW_REQUESTED = 'incident-review-requested';
    case INCIDENT_REVIEW_LATE = 'incident-review-late';
    case ADDITIONAL_INFORMATION_ADDED = 'additional-information-added';
    case FILES_UPLOADED = 'files-uploaded';
    case INCIDENT_CLOSED = 'incident-closed';
    case INCIDENT_REOPENED = 'incident-reopened';
    case INVESTIGATION_CREATED = 'investigation-created';
    case INVESTIGATION_RETURNED = 'investigation-returned';
    case RCA_CREATED = 'rca-created';
    case RCA_RETURNED = 'rca-returned';
    case COMMENT_ADDED = 'comment-added';
}
