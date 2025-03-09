
***

# Rapid Report Documentation



This is an automatically generated documentation for **Rapid Report Documentation**.


## Namespaces


### \App\Aggregates

#### Classes

| Class | Description |
|-------|-------------|
| [`IncidentAggregateRoot`](./classes/App/Aggregates/IncidentAggregateRoot.md) | Any<br />author<br />copyright<br />deprecated<br />example<br />final<br />ignore<br />internal<br />link<br />see<br />since<br />source<br />todo<br />uses<br />version|
| [`InvestigationAggregateRoot`](./classes/App/Aggregates/InvestigationAggregateRoot.md) | |
| [`RootCauseAnalysisAggregateRoot`](./classes/App/Aggregates/RootCauseAnalysisAggregateRoot.md) | |




### \App\Data

#### Classes

| Class | Description |
|-------|-------------|
| [`CommentData`](./classes/App/Data/CommentData.md) | |
| [`ExportData`](./classes/App/Data/ExportData.md) | |
| [`IncidentData`](./classes/App/Data/IncidentData.md) | |
| [`InvestigationData`](./classes/App/Data/InvestigationData.md) | |
| [`RootCauseAnalysisData`](./classes/App/Data/RootCauseAnalysisData.md) | |




### \App\Exceptions

#### Classes

| Class | Description |
|-------|-------------|
| [`UserNotSupervisorException`](./classes/App/Exceptions/UserNotSupervisorException.md) | |




### \App\Exports

#### Classes

| Class | Description |
|-------|-------------|
| [`IncidentsExport`](./classes/App/Exports/IncidentsExport.md) | |




### \App\Http\Controllers

#### Classes

| Class | Description |
|-------|-------------|
| [`Controller`](./classes/App/Http/Controllers/Controller.md) | |
| [`DashboardController`](./classes/App/Http/Controllers/DashboardController.md) | |
| [`NotificationController`](./classes/App/Http/Controllers/NotificationController.md) | |
| [`ProfileController`](./classes/App/Http/Controllers/ProfileController.md) | |




### \App\Http\Controllers\Auth

#### Classes

| Class | Description |
|-------|-------------|
| [`AuthenticatedSessionController`](./classes/App/Http/Controllers/Auth/AuthenticatedSessionController.md) | |
| [`ConfirmablePasswordController`](./classes/App/Http/Controllers/Auth/ConfirmablePasswordController.md) | |
| [`EmailVerificationNotificationController`](./classes/App/Http/Controllers/Auth/EmailVerificationNotificationController.md) | |
| [`EmailVerificationPromptController`](./classes/App/Http/Controllers/Auth/EmailVerificationPromptController.md) | |
| [`NewPasswordController`](./classes/App/Http/Controllers/Auth/NewPasswordController.md) | |
| [`PasswordController`](./classes/App/Http/Controllers/Auth/PasswordController.md) | |
| [`PasswordResetLinkController`](./classes/App/Http/Controllers/Auth/PasswordResetLinkController.md) | |
| [`RegisteredUserController`](./classes/App/Http/Controllers/Auth/RegisteredUserController.md) | |
| [`VerifyEmailController`](./classes/App/Http/Controllers/Auth/VerifyEmailController.md) | |




### \App\Http\Controllers\Incident

#### Classes

| Class | Description |
|-------|-------------|
| [`AssignedIncidentsController`](./classes/App/Http/Controllers/Incident/AssignedIncidentsController.md) | |
| [`IncidentAdditionalInformationController`](./classes/App/Http/Controllers/Incident/IncidentAdditionalInformationController.md) | |
| [`IncidentCommentController`](./classes/App/Http/Controllers/Incident/IncidentCommentController.md) | |
| [`IncidentController`](./classes/App/Http/Controllers/Incident/IncidentController.md) | |
| [`IncidentFileController`](./classes/App/Http/Controllers/Incident/IncidentFileController.md) | |
| [`IncidentStatusController`](./classes/App/Http/Controllers/Incident/IncidentStatusController.md) | |
| [`OwnedIncidentsController`](./classes/App/Http/Controllers/Incident/OwnedIncidentsController.md) | |
| [`SearchIncidentsController`](./classes/App/Http/Controllers/Incident/SearchIncidentsController.md) | |




### \App\Http\Controllers\Investigation

#### Classes

| Class | Description |
|-------|-------------|
| [`InvestigationController`](./classes/App/Http/Controllers/Investigation/InvestigationController.md) | |




### \App\Http\Controllers\Report

#### Classes

| Class | Description |
|-------|-------------|
| [`ExportController`](./classes/App/Http/Controllers/Report/ExportController.md) | |
| [`ReportController`](./classes/App/Http/Controllers/Report/ReportController.md) | |




### \App\Http\Controllers\RootCauseAnalysis

#### Classes

| Class | Description |
|-------|-------------|
| [`RootCauseAnalysisController`](./classes/App/Http/Controllers/RootCauseAnalysis/RootCauseAnalysisController.md) | |




### \App\Http\Controllers\User

#### Classes

| Class | Description |
|-------|-------------|
| [`UserController`](./classes/App/Http/Controllers/User/UserController.md) | |
| [`UserRoleController`](./classes/App/Http/Controllers/User/UserRoleController.md) | |




### \App\Http\Middleware

#### Classes

| Class | Description |
|-------|-------------|
| [`HandleInertiaRequests`](./classes/App/Http/Middleware/HandleInertiaRequests.md) | |
| [`HandleMarkingNotificationsAsRead`](./classes/App/Http/Middleware/HandleMarkingNotificationsAsRead.md) | |




### \App\Http\Requests

#### Classes

| Class | Description |
|-------|-------------|
| [`ProfileUpdateRequest`](./classes/App/Http/Requests/ProfileUpdateRequest.md) | |




### \App\Http\Requests\Auth

#### Classes

| Class | Description |
|-------|-------------|
| [`LoginRequest`](./classes/App/Http/Requests/Auth/LoginRequest.md) | |




### \App\Mail

#### Classes

| Class | Description |
|-------|-------------|
| [`IncidentReceived`](./classes/App/Mail/IncidentReceived.md) | |
| [`UserAdded`](./classes/App/Mail/UserAdded.md) | |




### \App\Models

#### Classes

| Class | Description |
|-------|-------------|
| [`Comment`](./classes/App/Models/Comment.md) | |
| [`CustomStoredEvent`](./classes/App/Models/CustomStoredEvent.md) | |
| [`File`](./classes/App/Models/File.md) | |
| [`Incident`](./classes/App/Models/Incident.md) | |
| [`Investigation`](./classes/App/Models/Investigation.md) | |
| [`RootCauseAnalysis`](./classes/App/Models/RootCauseAnalysis.md) | |
| [`User`](./classes/App/Models/User.md) | |




### \App\Notifications

#### Classes

| Class | Description |
|-------|-------------|
| [`BaseNotification`](./classes/App/Notifications/BaseNotification.md) | |




### \App\Notifications\Comment

#### Classes

| Class | Description |
|-------|-------------|
| [`CommentAdded`](./classes/App/Notifications/Comment/CommentAdded.md) | |




### \App\Notifications\Incident

#### Classes

| Class | Description |
|-------|-------------|
| [`AdditionalInformationNotification`](./classes/App/Notifications/Incident/AdditionalInformationNotification.md) | |
| [`FilesUploadedNotification`](./classes/App/Notifications/Incident/FilesUploadedNotification.md) | |
| [`IncidentClosedNotification`](./classes/App/Notifications/Incident/IncidentClosedNotification.md) | |
| [`IncidentFollowUpOverdueNotification`](./classes/App/Notifications/Incident/IncidentFollowUpOverdueNotification.md) | |
| [`IncidentReopenedNotification`](./classes/App/Notifications/Incident/IncidentReopenedNotification.md) | |
| [`IncidentReviewRequestNotification`](./classes/App/Notifications/Incident/IncidentReviewRequestNotification.md) | |
| [`IncidentSubmittedNotification`](./classes/App/Notifications/Incident/IncidentSubmittedNotification.md) | |
| [`SupervisorAssignedNotification`](./classes/App/Notifications/Incident/SupervisorAssignedNotification.md) | |




### \App\Notifications\Investigation

#### Classes

| Class | Description |
|-------|-------------|
| [`InvestigationReturnedNotification`](./classes/App/Notifications/Investigation/InvestigationReturnedNotification.md) | |
| [`InvestigationSubmittedNotification`](./classes/App/Notifications/Investigation/InvestigationSubmittedNotification.md) | |




### \App\Notifications\RootCauseAnalysis

#### Classes

| Class | Description |
|-------|-------------|
| [`RootCauseAnalysisReturnedNotification`](./classes/App/Notifications/RootCauseAnalysis/RootCauseAnalysisReturnedNotification.md) | |
| [`RootCauseAnalysisSubmittedNotification`](./classes/App/Notifications/RootCauseAnalysis/RootCauseAnalysisSubmittedNotification.md) | |




### \App\Policies

#### Classes

| Class | Description |
|-------|-------------|
| [`DashboardPolicy`](./classes/App/Policies/DashboardPolicy.md) | |
| [`IncidentPolicy`](./classes/App/Policies/IncidentPolicy.md) | |
| [`InvestigationPolicy`](./classes/App/Policies/InvestigationPolicy.md) | |
| [`ReportPolicy`](./classes/App/Policies/ReportPolicy.md) | |
| [`RootCauseAnalysisPolicy`](./classes/App/Policies/RootCauseAnalysisPolicy.md) | |
| [`UserPolicy`](./classes/App/Policies/UserPolicy.md) | |




### \App\Projectors

#### Classes

| Class | Description |
|-------|-------------|
| [`StoredEventProjector`](./classes/App/Projectors/StoredEventProjector.md) | |




### \App\Providers

#### Classes

| Class | Description |
|-------|-------------|
| [`AppServiceProvider`](./classes/App/Providers/AppServiceProvider.md) | |




### \App\Reactors

#### Classes

| Class | Description |
|-------|-------------|
| [`StoredEventReactor`](./classes/App/Reactors/StoredEventReactor.md) | |




### \App\States\IncidentStatus

#### Classes

| Class | Description |
|-------|-------------|
| [`Assigned`](./classes/App/States/IncidentStatus/Assigned.md) | |
| [`Closed`](./classes/App/States/IncidentStatus/Closed.md) | |
| [`InReview`](./classes/App/States/IncidentStatus/InReview.md) | |
| [`IncidentStatusState`](./classes/App/States/IncidentStatus/IncidentStatusState.md) | |
| [`Opened`](./classes/App/States/IncidentStatus/Opened.md) | |
| [`Reopened`](./classes/App/States/IncidentStatus/Reopened.md) | |
| [`Returned`](./classes/App/States/IncidentStatus/Returned.md) | |




### \App\StorableEvents

#### Classes

| Class | Description |
|-------|-------------|
| [`StoredEvent`](./classes/App/StorableEvents/StoredEvent.md) | StoredEvent should be inherited for all events<br />and their handle and react methods should be overloaded as needed.|




### \App\StorableEvents\Comment

#### Classes

| Class | Description |
|-------|-------------|
| [`CommentCreated`](./classes/App/StorableEvents/Comment/CommentCreated.md) | StoredEvent should be inherited for all events<br />and their handle and react methods should be overloaded as needed.|




### \App\StorableEvents\Incident

#### Classes

| Class | Description |
|-------|-------------|
| [`AdditionalInformationAdded`](./classes/App/StorableEvents/Incident/AdditionalInformationAdded.md) | StoredEvent should be inherited for all events<br />and their handle and react methods should be overloaded as needed.|
| [`FileCreated`](./classes/App/StorableEvents/Incident/FileCreated.md) | StoredEvent should be inherited for all events<br />and their handle and react methods should be overloaded as needed.|
| [`FilesUploaded`](./classes/App/StorableEvents/Incident/FilesUploaded.md) | StoredEvent should be inherited for all events<br />and their handle and react methods should be overloaded as needed.|
| [`IncidentClosed`](./classes/App/StorableEvents/Incident/IncidentClosed.md) | StoredEvent should be inherited for all events<br />and their handle and react methods should be overloaded as needed.|
| [`IncidentCreated`](./classes/App/StorableEvents/Incident/IncidentCreated.md) | StoredEvent should be inherited for all events<br />and their handle and react methods should be overloaded as needed.|
| [`IncidentReopened`](./classes/App/StorableEvents/Incident/IncidentReopened.md) | StoredEvent should be inherited for all events<br />and their handle and react methods should be overloaded as needed.|
| [`IncidentReviewRequested`](./classes/App/StorableEvents/Incident/IncidentReviewRequested.md) | StoredEvent should be inherited for all events<br />and their handle and react methods should be overloaded as needed.|
| [`SupervisorAssigned`](./classes/App/StorableEvents/Incident/SupervisorAssigned.md) | StoredEvent should be inherited for all events<br />and their handle and react methods should be overloaded as needed.|
| [`SupervisorUnassigned`](./classes/App/StorableEvents/Incident/SupervisorUnassigned.md) | StoredEvent should be inherited for all events<br />and their handle and react methods should be overloaded as needed.|




### \App\StorableEvents\Investigation

#### Classes

| Class | Description |
|-------|-------------|
| [`InvestigationCreated`](./classes/App/StorableEvents/Investigation/InvestigationCreated.md) | StoredEvent should be inherited for all events<br />and their handle and react methods should be overloaded as needed.|
| [`InvestigationReturned`](./classes/App/StorableEvents/Investigation/InvestigationReturned.md) | StoredEvent should be inherited for all events<br />and their handle and react methods should be overloaded as needed.|




### \App\StorableEvents\RootCauseAnalysis

#### Classes

| Class | Description |
|-------|-------------|
| [`RootCauseAnalysisCreated`](./classes/App/StorableEvents/RootCauseAnalysis/RootCauseAnalysisCreated.md) | StoredEvent should be inherited for all events<br />and their handle and react methods should be overloaded as needed.|
| [`RootCauseAnalysisReturned`](./classes/App/StorableEvents/RootCauseAnalysis/RootCauseAnalysisReturned.md) | StoredEvent should be inherited for all events<br />and their handle and react methods should be overloaded as needed.|




### \App\StorableEvents\User

#### Classes

| Class | Description |
|-------|-------------|
| [`UserCreated`](./classes/App/StorableEvents/User/UserCreated.md) | StoredEvent should be inherited for all events<br />and their handle and react methods should be overloaded as needed.|
| [`UserDeleted`](./classes/App/StorableEvents/User/UserDeleted.md) | StoredEvent should be inherited for all events<br />and their handle and react methods should be overloaded as needed.|
| [`UserRoleUpdated`](./classes/App/StorableEvents/User/UserRoleUpdated.md) | StoredEvent should be inherited for all events<br />and their handle and react methods should be overloaded as needed.|




### \Database\Factories

#### Classes

| Class | Description |
|-------|-------------|
| [`CommentFactory`](./classes/Database/Factories/CommentFactory.md) | |
| [`FileFactory`](./classes/Database/Factories/FileFactory.md) | |
| [`IncidentFactory`](./classes/Database/Factories/IncidentFactory.md) | |
| [`InvestigationFactory`](./classes/Database/Factories/InvestigationFactory.md) | |
| [`RootCauseAnalysisFactory`](./classes/Database/Factories/RootCauseAnalysisFactory.md) | |
| [`UserFactory`](./classes/Database/Factories/UserFactory.md) | |




### \Database\Seeders

#### Classes

| Class | Description |
|-------|-------------|
| [`DatabaseSeeder`](./classes/Database/Seeders/DatabaseSeeder.md) | |
| [`RolesAndPermissionsSeeder`](./classes/Database/Seeders/RolesAndPermissionsSeeder.md) | |




### \Tests

#### Classes

| Class | Description |
|-------|-------------|
| [`TestCase`](./classes/Tests/TestCase.md) | |




### \Tests\Feature

#### Classes

| Class | Description |
|-------|-------------|
| [`DashboardTest`](./classes/Tests/Feature/DashboardTest.md) | |
| [`NotificationTest`](./classes/Tests/Feature/NotificationTest.md) | |
| [`ProfileTest`](./classes/Tests/Feature/ProfileTest.md) | |




### \Tests\Feature\Auth

#### Classes

| Class | Description |
|-------|-------------|
| [`AuthenticationTest`](./classes/Tests/Feature/Auth/AuthenticationTest.md) | |
| [`EmailVerificationTest`](./classes/Tests/Feature/Auth/EmailVerificationTest.md) | |
| [`PasswordConfirmationTest`](./classes/Tests/Feature/Auth/PasswordConfirmationTest.md) | |
| [`PasswordResetTest`](./classes/Tests/Feature/Auth/PasswordResetTest.md) | |
| [`PasswordUpdateTest`](./classes/Tests/Feature/Auth/PasswordUpdateTest.md) | |
| [`RegistrationTest`](./classes/Tests/Feature/Auth/RegistrationTest.md) | |




### \Tests\Feature\Incident

#### Classes

| Class | Description |
|-------|-------------|
| [`AddCommentTest`](./classes/Tests/Feature/Incident/AddCommentTest.md) | |
| [`AdditionalInformationTest`](./classes/Tests/Feature/Incident/AdditionalInformationTest.md) | |
| [`CreateTest`](./classes/Tests/Feature/Incident/CreateTest.md) | |
| [`FileTest`](./classes/Tests/Feature/Incident/FileTest.md) | |
| [`IndexTest`](./classes/Tests/Feature/Incident/IndexTest.md) | |
| [`SearchTest`](./classes/Tests/Feature/Incident/SearchTest.md) | |
| [`ShowTest`](./classes/Tests/Feature/Incident/ShowTest.md) | |
| [`StatusTest`](./classes/Tests/Feature/Incident/StatusTest.md) | |
| [`StoreTest`](./classes/Tests/Feature/Incident/StoreTest.md) | |
| [`SupervisorTest`](./classes/Tests/Feature/Incident/SupervisorTest.md) | |




### \Tests\Feature\Investigation

#### Classes

| Class | Description |
|-------|-------------|
| [`CreateTest`](./classes/Tests/Feature/Investigation/CreateTest.md) | |
| [`ShowTest`](./classes/Tests/Feature/Investigation/ShowTest.md) | |
| [`StoreTest`](./classes/Tests/Feature/Investigation/StoreTest.md) | |




### \Tests\Feature\Report

#### Classes

| Class | Description |
|-------|-------------|
| [`ExportCSVTest`](./classes/Tests/Feature/Report/ExportCSVTest.md) | |
| [`ExportXLSXTest`](./classes/Tests/Feature/Report/ExportXLSXTest.md) | |
| [`IndexTest`](./classes/Tests/Feature/Report/IndexTest.md) | |
| [`StatsTest`](./classes/Tests/Feature/Report/StatsTest.md) | |




### \Tests\Feature\RootCauseAnalysis

#### Classes

| Class | Description |
|-------|-------------|
| [`CreateTest`](./classes/Tests/Feature/RootCauseAnalysis/CreateTest.md) | |
| [`ShowTest`](./classes/Tests/Feature/RootCauseAnalysis/ShowTest.md) | |
| [`StoreTest`](./classes/Tests/Feature/RootCauseAnalysis/StoreTest.md) | |




### \Tests\Feature\User

#### Classes

| Class | Description |
|-------|-------------|
| [`DestroyTest`](./classes/Tests/Feature/User/DestroyTest.md) | |
| [`StoreTest`](./classes/Tests/Feature/User/StoreTest.md) | |
| [`UserRoleTest`](./classes/Tests/Feature/User/UserRoleTest.md) | |




### \Tests\Unit\Aggregates

#### Classes

| Class | Description |
|-------|-------------|
| [`IncidentAggregateRootTest`](./classes/Tests/Unit/Aggregates/IncidentAggregateRootTest.md) | |
| [`InvestigationAggregateRootTest`](./classes/Tests/Unit/Aggregates/InvestigationAggregateRootTest.md) | |
| [`RootCauseAnalysisAggregateRootTest`](./classes/Tests/Unit/Aggregates/RootCauseAnalysisAggregateRootTest.md) | |




### \Tests\Unit\Data

#### Classes

| Class | Description |
|-------|-------------|
| [`CommentDataTest`](./classes/Tests/Unit/Data/CommentDataTest.md) | |
| [`ExportDataTest`](./classes/Tests/Unit/Data/ExportDataTest.md) | |
| [`IncidentDataTest`](./classes/Tests/Unit/Data/IncidentDataTest.md) | |
| [`InvestigationDataTest`](./classes/Tests/Unit/Data/InvestigationDataTest.md) | |
| [`RootCauseAnalysisDataTest`](./classes/Tests/Unit/Data/RootCauseAnalysisDataTest.md) | |




### \Tests\Unit\Models

#### Classes

| Class | Description |
|-------|-------------|
| [`CommentTest`](./classes/Tests/Unit/Models/CommentTest.md) | |
| [`FileTest`](./classes/Tests/Unit/Models/FileTest.md) | |
| [`IncidentTest`](./classes/Tests/Unit/Models/IncidentTest.md) | |
| [`InvestigationTest`](./classes/Tests/Unit/Models/InvestigationTest.md) | |
| [`RootCauseAnalysisTest`](./classes/Tests/Unit/Models/RootCauseAnalysisTest.md) | |
| [`UserTest`](./classes/Tests/Unit/Models/UserTest.md) | |




### \Tests\Unit\Policies

#### Classes

| Class | Description |
|-------|-------------|
| [`DashboardPolicyTest`](./classes/Tests/Unit/Policies/DashboardPolicyTest.md) | |
| [`IncidentPolicyTest`](./classes/Tests/Unit/Policies/IncidentPolicyTest.md) | |
| [`InvestigationPolicyTest`](./classes/Tests/Unit/Policies/InvestigationPolicyTest.md) | |
| [`ReportPolicyTest`](./classes/Tests/Unit/Policies/ReportPolicyTest.md) | |
| [`RootCauseAnalysisPolicyTest`](./classes/Tests/Unit/Policies/RootCauseAnalysisPolicyTest.md) | |
| [`UserPolicyTest`](./classes/Tests/Unit/Policies/UserPolicyTest.md) | |




### \Tests\Unit\Projectors

#### Classes

| Class | Description |
|-------|-------------|
| [`StoredEventProjectorTest`](./classes/Tests/Unit/Projectors/StoredEventProjectorTest.md) | |




### \Tests\Unit\Reactors

#### Classes

| Class | Description |
|-------|-------------|
| [`StoredEventReactorTest`](./classes/Tests/Unit/Reactors/StoredEventReactorTest.md) | |




### \Tests\Unit\States

#### Classes

| Class | Description |
|-------|-------------|
| [`IncidentStatusStateTest`](./classes/Tests/Unit/States/IncidentStatusStateTest.md) | |




### \Tests\Unit\StoreableEvents\Comment

#### Classes

| Class | Description |
|-------|-------------|
| [`CommentCreatedTest`](./classes/Tests/Unit/StoreableEvents/Comment/CommentCreatedTest.md) | |




### \Tests\Unit\StoreableEvents\Incident

#### Classes

| Class | Description |
|-------|-------------|
| [`AdditionalInformationAddedTest`](./classes/Tests/Unit/StoreableEvents/Incident/AdditionalInformationAddedTest.md) | |
| [`FileCreatedTest`](./classes/Tests/Unit/StoreableEvents/Incident/FileCreatedTest.md) | |
| [`FilesUploadedTest`](./classes/Tests/Unit/StoreableEvents/Incident/FilesUploadedTest.md) | |
| [`IncidentClosedTest`](./classes/Tests/Unit/StoreableEvents/Incident/IncidentClosedTest.md) | |
| [`IncidentCreatedTest`](./classes/Tests/Unit/StoreableEvents/Incident/IncidentCreatedTest.md) | |
| [`IncidentReopenedTest`](./classes/Tests/Unit/StoreableEvents/Incident/IncidentReopenedTest.md) | |
| [`IncidentReviewRequestedTest`](./classes/Tests/Unit/StoreableEvents/Incident/IncidentReviewRequestedTest.md) | |
| [`SupervisorAssignedTest`](./classes/Tests/Unit/StoreableEvents/Incident/SupervisorAssignedTest.md) | |
| [`SupervisorUnassignedTest`](./classes/Tests/Unit/StoreableEvents/Incident/SupervisorUnassignedTest.md) | |




### \Tests\Unit\StoreableEvents\Investigation

#### Classes

| Class | Description |
|-------|-------------|
| [`InvestigationCreatedTest`](./classes/Tests/Unit/StoreableEvents/Investigation/InvestigationCreatedTest.md) | |
| [`InvestigationReturnedTest`](./classes/Tests/Unit/StoreableEvents/Investigation/InvestigationReturnedTest.md) | |




### \Tests\Unit\StoreableEvents\RootCauseAnalysis

#### Classes

| Class | Description |
|-------|-------------|
| [`RootCauseAnalysisCreatedTest`](./classes/Tests/Unit/StoreableEvents/RootCauseAnalysis/RootCauseAnalysisCreatedTest.md) | |
| [`RootCauseAnalysisReturnedTest`](./classes/Tests/Unit/StoreableEvents/RootCauseAnalysis/RootCauseAnalysisReturnedTest.md) | |




### \Tests\Unit\StoreableEvents\User

#### Classes

| Class | Description |
|-------|-------------|
| [`UserCreatedTest`](./classes/Tests/Unit/StoreableEvents/User/UserCreatedTest.md) | |
| [`UserDeletedTest`](./classes/Tests/Unit/StoreableEvents/User/UserDeletedTest.md) | |
| [`UserRoleUpdatedTest`](./classes/Tests/Unit/StoreableEvents/User/UserRoleUpdatedTest.md) | |




***
> Automatically generated on 2025-03-07
