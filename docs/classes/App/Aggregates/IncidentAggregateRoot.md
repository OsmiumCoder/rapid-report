***

# IncidentAggregateRoot

Any
author
copyright
deprecated
example
final
ignore
internal
link
see
since
source
todo
uses
version

Class
category
licence
method
package
property
property-read
property-write
subpackage

Methods
api
param
return
throw

* Full name: `\App\Aggregates\IncidentAggregateRoot`
* Parent class: [`AggregateRoot`](../../Spatie/EventSourcing/AggregateRoots/AggregateRoot.md)




## Methods


### createIncident



```php
public createIncident(\App\Data\IncidentData $incidentData): static
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incidentData` | **\App\Data\IncidentData** |  |





***

### assignSupervisor



```php
public assignSupervisor(int $supervisorId): static
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
public unassignSupervisor(): static
```












***

### requestReview



```php
public requestReview(): static
```












***

### returnInvestigation



```php
public returnInvestigation(): static
```












***

### returnRCA



```php
public returnRCA(): static
```












***

### closeIncident



```php
public closeIncident(): static
```












***

### reopenIncident



```php
public reopenIncident(): static
```












***

### addComment



```php
public addComment(\App\Data\CommentData $commentData): static
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$commentData` | **\App\Data\CommentData** |  |





***

### addAdditionalInformation



```php
public addAdditionalInformation(string $additionalInformation): static
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$additionalInformation` | **string** |  |





***

### uploadFiles



```php
public uploadFiles(array $files): static
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$files` | **array** |  |





***


***
> Automatically generated on 2025-03-07
