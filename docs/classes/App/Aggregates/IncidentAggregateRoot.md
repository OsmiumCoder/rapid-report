***

# IncidentAggregateRoot





* Full name: `\App\Aggregates\IncidentAggregateRoot`
* Parent class: [`AggregateRoot`](../../Spatie/EventSourcing/AggregateRoots/AggregateRoot.md)




## Methods


### createIncident



```php
public createIncident(\App\Data\IncidentData $incidentData): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incidentData` | **\App\Data\IncidentData** |  |





***

### assignSupervisor



```php
public assignSupervisor(int $supervisorId): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$supervisorId` | **int** |  |




**Throws:**

- [`UserNotSupervisorException`](../Exceptions/UserNotSupervisorException.md)



***

### unassignSupervisor



```php
public unassignSupervisor(): mixed
```












***

### requestReview



```php
public requestReview(): mixed
```












***

### returnInvestigation



```php
public returnInvestigation(): mixed
```












***

### returnRCA



```php
public returnRCA(): mixed
```












***

### closeIncident



```php
public closeIncident(): mixed
```












***

### reopenIncident



```php
public reopenIncident(): mixed
```












***

### addComment



```php
public addComment(\App\Data\CommentData $commentData): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$commentData` | **\App\Data\CommentData** |  |





***

### addAdditionalInformation



```php
public addAdditionalInformation(string $additionalInformation): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$additionalInformation` | **string** |  |





***

### uploadFiles



```php
public uploadFiles(array $files): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$files` | **array** |  |





***


***
> Automatically generated on 2025-03-07
