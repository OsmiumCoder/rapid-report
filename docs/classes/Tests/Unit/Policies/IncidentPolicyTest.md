***

# IncidentPolicyTest





* Full name: `\Tests\Unit\Policies\IncidentPolicyTest`
* Parent class: [`\Tests\TestCase`](../../TestCase.md)




## Methods


### test_user_cant_download_files



```php
public test_user_cant_download_files(): mixed
```












***

### test_supervisor_cant_download_not_owned_file



```php
public test_supervisor_cant_download_not_owned_file(): mixed
```












***

### test_supervisor_can_download_owned_file



```php
public test_supervisor_can_download_owned_file(): mixed
```












***

### test_admin_can_download_any_files



```php
public test_admin_can_download_any_files(): mixed
```












***

### test_incident_reporter_can_add_additional_information



```php
public test_incident_reporter_can_add_additional_information(): mixed
```












***

### test_user_can_not_add_additional_information_to_incident_they_did_not_report



```php
public test_user_can_not_add_additional_information_to_incident_they_did_not_report(): mixed
```












***

### test_user_can_not_provide_follow_up_on_assigned_incident



```php
public test_user_can_not_provide_follow_up_on_assigned_incident(): mixed
```












***

### test_user_can_not_provide_follow_up_on_returned_incident



```php
public test_user_can_not_provide_follow_up_on_returned_incident(): mixed
```












***

### test_admin_can_not_provide_follow_up_on_assigned_incident



```php
public test_admin_can_not_provide_follow_up_on_assigned_incident(): mixed
```












***

### test_admin_can_not_provide_follow_up_on_returned_incident



```php
public test_admin_can_not_provide_follow_up_on_returned_incident(): mixed
```












***

### test_supervisor_can_not_provide_follow_up_on_closed_incident



```php
public test_supervisor_can_not_provide_follow_up_on_closed_incident(): mixed
```












***

### test_supervisor_can_not_provide_follow_up_on_reopened_incident



```php
public test_supervisor_can_not_provide_follow_up_on_reopened_incident(): mixed
```












***

### test_supervisor_can_not_provide_follow_up_on_in_review_incident



```php
public test_supervisor_can_not_provide_follow_up_on_in_review_incident(): mixed
```












***

### test_supervisor_can_not_provide_follow_up_on_open_incident



```php
public test_supervisor_can_not_provide_follow_up_on_open_incident(): mixed
```












***

### test_supervisor_can_provide_follow_up_on_returned_incident



```php
public test_supervisor_can_provide_follow_up_on_returned_incident(): mixed
```












***

### test_supervisor_can_provide_follow_up_on_assigned_incident



```php
public test_supervisor_can_provide_follow_up_on_assigned_incident(): mixed
```












***

### test_supervisor_can_request_review



```php
public test_supervisor_can_request_review(): mixed
```












***

### test_supervisor_cant_request_review_if_not_assigned_to_incident



```php
public test_supervisor_cant_request_review_if_not_assigned_to_incident(): mixed
```












***

### test_supervisor_cant_request_review_if_not_assigned_state



```php
public test_supervisor_cant_request_review_if_not_assigned_state(): mixed
```












***

### test_supervisor_cant_request_review_if_latest_investigation_and_root_cause_analyses_not_his



```php
public test_supervisor_cant_request_review_if_latest_investigation_and_root_cause_analyses_not_his(): mixed
```












***

### test_supervisor_cant_request_review_if_latest_investigation_not_his



```php
public test_supervisor_cant_request_review_if_latest_investigation_not_his(): mixed
```












***

### test_supervisor_cant_request_review_if_no_investigations_and_no_root_cause_analyses



```php
public test_supervisor_cant_request_review_if_no_investigations_and_no_root_cause_analyses(): mixed
```












***

### test_supervisor_can_request_review_if_no_root_cause_analyses



```php
public test_supervisor_can_request_review_if_no_root_cause_analyses(): mixed
```












***

### test_supervisor_cant_request_review_if_no_investigations



```php
public test_supervisor_cant_request_review_if_no_investigations(): mixed
```












***

### test_admin_cant_request_review



```php
public test_admin_cant_request_review(): mixed
```












***

### test_user_cant_request_review



```php
public test_user_cant_request_review(): mixed
```












***

### test_admin_can_search_for_all_incidents



```php
public test_admin_can_search_for_all_incidents(): mixed
```












***

### test_supervisor_can_search_for_assigned_incidents



```php
public test_supervisor_can_search_for_assigned_incidents(): mixed
```












***

### test_user_can_not_search_for_incidents



```php
public test_user_can_not_search_for_incidents(): mixed
```












***

### test_supervisor_can_add_comment_on_incident_they_own_but_arent_assigned



```php
public test_supervisor_can_add_comment_on_incident_they_own_but_arent_assigned(): mixed
```












***

### test_user_cant_add_comment_on_incident_they_dont_own



```php
public test_user_cant_add_comment_on_incident_they_dont_own(): mixed
```












***

### test_user_cant_comment_on_incidents



```php
public test_user_cant_comment_on_incidents(): mixed
```












***

### test_supervisor_cant_comment_on_incident_not_assigned_to_them



```php
public test_supervisor_cant_comment_on_incident_not_assigned_to_them(): mixed
```












***

### test_supervisor_can_comment_on_assigned_incident



```php
public test_supervisor_can_comment_on_assigned_incident(): mixed
```












***

### test_admin_can_comment_on_any_incident



```php
public test_admin_can_comment_on_any_incident(): mixed
```












***

### test_admin_can_perform_admin_actions_on_incidents



```php
public test_admin_can_perform_admin_actions_on_incidents(): mixed
```












***

### test_supervisor_can_not_perform_admin_actions_on_incidents



```php
public test_supervisor_can_not_perform_admin_actions_on_incidents(): mixed
```












***

### test_user_can_not_perform_admin_actions_on_incidents



```php
public test_user_can_not_perform_admin_actions_on_incidents(): mixed
```












***

### test_user_can_view_all_their_incidents



```php
public test_user_can_view_all_their_incidents(): mixed
```












***

### test_user_cant_view_any_assigned_incident



```php
public test_user_cant_view_any_assigned_incident(): mixed
```












***

### test_supervisor_can_view_any_assigned_incident



```php
public test_supervisor_can_view_any_assigned_incident(): mixed
```












***

### test_supervisor_can_view_incident_they_own_but_arent_assigned



```php
public test_supervisor_can_view_incident_they_own_but_arent_assigned(): mixed
```












***

### test_user_cant_view_incident_they_dont_own



```php
public test_user_cant_view_incident_they_dont_own(): mixed
```












***

### test_user_can_view_own_incident



```php
public test_user_can_view_own_incident(): mixed
```












***

### test_supervisor_cant_view_incident_not_assigned_to_them



```php
public test_supervisor_cant_view_incident_not_assigned_to_them(): mixed
```












***

### test_supervisor_can_view_assigned_incident



```php
public test_supervisor_can_view_assigned_incident(): mixed
```












***

### test_admin_can_view_any_single_incident



```php
public test_admin_can_view_any_single_incident(): mixed
```












***

### test_user_cant_view_all_incidents



```php
public test_user_cant_view_all_incidents(): mixed
```












***

### test_supervisor_cant_view_all_incidents



```php
public test_supervisor_cant_view_all_incidents(): mixed
```












***

### test_admin_can_view_all_incidents



```php
public test_admin_can_view_all_incidents(): mixed
```












***

### getPolicy



```php
protected getPolicy(): mixed
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
