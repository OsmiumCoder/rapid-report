***

# IncidentAggregateRoot

Handles all events related to incidents.



* Full name: `\App\Aggregates\IncidentAggregateRoot`
* Parent class: [`AggregateRoot`](../../Spatie/EventSourcing/AggregateRoots/AggregateRoot.md)

**See Also:**

* [`\App\Models\Incident`](../Models/Incident.md) - The model that is being aggregated.




## Methods


### createIncident

Records an IncidentCreated event.

```php
public createIncident(\App\Data\IncidentData $incidentData): $this
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incidentData` | **\App\Data\IncidentData** | The request data for the new incident. |





**See Also:**

* [`\App\StorableEvents\Incident\IncidentCreated`](../StorableEvents/Incident/IncidentCreated.md) - The event recorded by this method.


***

### assignSupervisor

Assigns the user of the given id to the aggregated incident.

```php
public assignSupervisor(int $supervisorId): $this
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$supervisorId` | **int** | Is user id of the supervisor to assign. |




**Throws:**
<p>If the user for the given id is not a supervisor.</p>

- [`UserNotSupervisorException`](../Exceptions/UserNotSupervisorException.md)



**See Also:**

* [`\App\StorableEvents\Incident\SupervisorAssigned`](../StorableEvents/Incident/SupervisorAssigned.md) - The event recored by this method.


***

### unassignSupervisor

Unassigns the current supervisor from the aggregated incident.

```php
public unassignSupervisor(): $this
```












**See Also:**

* [`\App\StorableEvents\Incident\SupervisorUnassigned`](../StorableEvents/Incident/SupervisorUnassigned.md) - The event recorded by this method.


***

### requestReview

Transitions the aggregated incident to In Review status.

```php
public requestReview(): $this
```












**See Also:**

* [`\App\StorableEvents\Incident\IncidentReviewRequested`](../StorableEvents/Incident/IncidentReviewRequested.md) - The event recorded by this method.


***

### returnInvestigation

Transitions the aggregated incident to Returned status, for current investigation.

```php
public returnInvestigation(): $this
```












**See Also:**

* [`\App\StorableEvents\Investigation\InvestigationReturned`](../StorableEvents/Investigation/InvestigationReturned.md) - The event recorded by this method.
* [`\App\States\IncidentStatus\Returned`](../States/IncidentStatus/Returned.md) - The status the incident will transition to.


***

### returnRCA

Transitions the aggregated incident to Returned status, for current root cause analysis.

```php
public returnRCA(): $this
```












**See Also:**

* [`\App\StorableEvents\RootCauseAnalysis\RootCauseAnalysisReturned`](../StorableEvents/RootCauseAnalysis/RootCauseAnalysisReturned.md) - The event recorded by this method.
* [`\App\States\IncidentStatus\Returned`](../States/IncidentStatus/Returned.md) - The status the incident will transition to.


***

### closeIncident

Transitions the aggregated incident to Closed status.

```php
public closeIncident(): $this
```












**See Also:**

* [`\App\StorableEvents\Incident\IncidentClosed`](../StorableEvents/Incident/IncidentClosed.md) - The event recorded by this method.
* [`\App\States\IncidentStatus\Closed`](../States/IncidentStatus/Closed.md) - The status the incident will transition to.


***

### reopenIncident

Transitions the aggregated incident to Reopened status.

```php
public reopenIncident(): $this
```












**See Also:**

* [`\App\StorableEvents\Incident\IncidentReopened`](../StorableEvents/Incident/IncidentReopened.md) - The event recorded by this method.
* [`\App\States\IncidentStatus\Reopened`](../States/IncidentStatus/Reopened.md) - The status the incident will transition to.


***

### addComment

Attaches a comment to the aggregated incident.

```php
public addComment(\App\Data\CommentData $commentData): $this
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$commentData` | **\App\Data\CommentData** | The request containing the comment to add. |





**See Also:**

* [`\App\StorableEvents\Comment\CommentCreated`](../StorableEvents/Comment/CommentCreated.md) - The event recorded by this method.


***

### addAdditionalInformation

Adds provided additional information to the aggregated incident.

```php
public addAdditionalInformation(string $additionalInformation): $this
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$additionalInformation` | **string** | The additional information text to add to the incident. |





***

### uploadFiles

Stores and attaches files to the aggregated incident.

```php
public uploadFiles(\Illuminate\Http\UploadedFile[] $files): $this
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$files` | **\Illuminate\Http\UploadedFile[]** | The list of uploaded files to store |





**See Also:**

* [`\App\StorableEvents\Incident\FileCreated`](../StorableEvents/Incident/FileCreated.md) - Is recorded for every file that is stored.
* [`\App\StorableEvents\Incident\FilesUploaded`](../StorableEvents/Incident/FilesUploaded.md) - Is recorded when all files have been stored.


***


***
> Automatically generated on 2025-03-14
