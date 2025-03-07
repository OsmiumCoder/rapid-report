***

# IncidentAggregateRootTest





* Full name: `\Tests\Unit\Aggregates\IncidentAggregateRootTest`
* Parent class: [`\Tests\TestCase`](../../TestCase.md)




## Methods


### test_uploaded_files_are_stored



```php
public test_uploaded_files_are_stored(): mixed
```












***

### test_upload_files_fires_file_upload_events



```php
public test_upload_files_fires_file_upload_events(): mixed
```












***

### test_add_additional_information_fires_add_additional_information_event



```php
public test_add_additional_information_fires_add_additional_information_event(): mixed
```












***

### test_request_review_fires_incident_review_requested_event



```php
public test_request_review_fires_incident_review_requested_event(): mixed
```












***

### test_return_rca_fires_rca_returned_event



```php
public test_return_rca_fires_rca_returned_event(): mixed
```












***

### test_first_additional_information_on_incident_creates_new_array



```php
public test_first_additional_information_on_incident_creates_new_array(): mixed
```












***

### test_additional_information_appends_to_current_additional_information_on_incident



```php
public test_additional_information_appends_to_current_additional_information_on_incident(): mixed
```












***

### test_sends_additional_information_added_to_admins



```php
public test_sends_additional_information_added_to_admins(): mixed
```












***

### test_additional_information_notification_stored_in_database



```php
public test_additional_information_notification_stored_in_database(): mixed
```












***

### test_sends_investigation_returned_notification_to_supervisor



```php
public test_sends_investigation_returned_notification_to_supervisor(): mixed
```












***

### test_stores_request_notification_in_database



```php
public test_stores_request_notification_in_database(): mixed
```












***

### test_request_review_sends_request_notification_to_admin



```php
public test_request_review_sends_request_notification_to_admin(): mixed
```












***

### test_request_review_adds_review_requested_comment



```php
public test_request_review_adds_review_requested_comment(): mixed
```












***

### test_request_review_throws_if_not_assigned



```php
public test_request_review_throws_if_not_assigned(): mixed
```












***

### test_request_review_transitions_incident_from_assigned_to_in_review



```php
public test_request_review_transitions_incident_from_assigned_to_in_review(): mixed
```












***

### test_return_investigation_sets_returned_status



```php
public test_return_investigation_sets_returned_status(): mixed
```












***

### test_return_investigation_adds_returned_comment



```php
public test_return_investigation_adds_returned_comment(): mixed
```












***

### test_return_investigation_fires_investigation_returned_event



```php
public test_return_investigation_fires_investigation_returned_event(): mixed
```












***

### test_reopen_incident_adds_reopened_comment



```php
public test_reopen_incident_adds_reopened_comment(): mixed
```












***

### test_close_incident_adds_closed_comment



```php
public test_close_incident_adds_closed_comment(): mixed
```












***

### test_unassign_supervisor_adds_unassigned_comment



```php
public test_unassign_supervisor_adds_unassigned_comment(): mixed
```












***

### test_assign_supervisor_throws_user_not_supervisor_if_id_not_supervisor



```php
public test_assign_supervisor_throws_user_not_supervisor_if_id_not_supervisor(): mixed
```












***

### test_assign_supervisor_adds_assigned_comment



```php
public test_assign_supervisor_adds_assigned_comment(): mixed
```












***

### test_add_comment_adds_comment_to_incident



```php
public test_add_comment_adds_comment_to_incident(): mixed
```












***

### test_add_comment_fires_comment_created_event



```php
public test_add_comment_fires_comment_created_event(): mixed
```












***

### test_close_incident_fires_incident_closed_event



```php
public test_close_incident_fires_incident_closed_event(): mixed
```












***

### test_close_incident_sets_incident_status_to_closed



```php
public test_close_incident_sets_incident_status_to_closed(): mixed
```












***

### test_reopened_incident_fires_incident_reopened_event



```php
public test_reopened_incident_fires_incident_reopened_event(): mixed
```












***

### test_reopen_incident_sets_status_to_reopened



```php
public test_reopen_incident_sets_status_to_reopened(): mixed
```












***

### test_unassigned_supervisor_fires_supervisor_unassigned_event



```php
public test_unassigned_supervisor_fires_supervisor_unassigned_event(): mixed
```












***

### test_unassign_supervisor_unassigns_supervisor_from_incident



```php
public test_unassign_supervisor_unassigns_supervisor_from_incident(): mixed
```












***

### test_assigned_supervisor_fires_supervisor_assigned_event



```php
public test_assigned_supervisor_fires_supervisor_assigned_event(): mixed
```












***

### test_assign_supervisor_assigns_supervisor_to_incident



```php
public test_assign_supervisor_assigns_supervisor_to_incident(): mixed
```












***

### test_create_incident_adds_created_comment



```php
public test_create_incident_adds_created_comment(): mixed
```












***

### test_create_incident_fires_incident_created_event



```php
public test_create_incident_fires_incident_created_event(): mixed
```












***

### test_create_incident_stored_incident_uuid_is_aggregate_uuid



```php
public test_create_incident_stored_incident_uuid_is_aggregate_uuid(): mixed
```












***

### test_create_incident_stores_incident



```php
public test_create_incident_stores_incident(): mixed
```












***

### test_create_incident_sends_mail_on_reporters_email_set



```php
public test_create_incident_sends_mail_on_reporters_email_set(): void
```












***

### test_create_incident_sends_no_mail_on_reporters_email_not_set



```php
public test_create_incident_sends_no_mail_on_reporters_email_not_set(): void
```












***

### test_create_incident_notifies_admin_team



```php
public test_create_incident_notifies_admin_team(): void
```












***

### test_comment_notifies_admin_team



```php
public test_comment_notifies_admin_team(): void
```












***

### test_comment_notifies_supervisor_when_supervisor_is_set



```php
public test_comment_notifies_supervisor_when_supervisor_is_set(): void
```












***

### test_comment_does_not_notify_supervisor_when_supervisor_is_not_set



```php
public test_comment_does_not_notify_supervisor_when_supervisor_is_not_set(): void
```












***

### test_comment_notifies_admin_team_and_supervisor_when_supervisor_is_set



```php
public test_comment_notifies_admin_team_and_supervisor_when_supervisor_is_set(): void
```












***

### test_close_incident_notifies_supervisor_when_set



```php
public test_close_incident_notifies_supervisor_when_set(): mixed
```












***

### test_close_incident_does_not_notify_supervisor_when_not_set



```php
public test_close_incident_does_not_notify_supervisor_when_not_set(): mixed
```












***

### test_close_incident_notifies_admin_team



```php
public test_close_incident_notifies_admin_team(): mixed
```












***

### test_reopened_incident_notifies_admins



```php
public test_reopened_incident_notifies_admins(): mixed
```












***


## Inherited methods


### setUp



```php
protected setUp(): void
```












***


***
> Automatically generated on 2025-03-07
