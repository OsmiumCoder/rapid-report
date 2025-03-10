***

# IncidentStatusController





* Full name: `\App\Http\Controllers\Incident\IncidentStatusController`
* Parent class: [`\App\Http\Controllers\Controller`](../Controller.md)




## Methods


### requestReview



```php
public requestReview(\App\Models\Incident $incident): \Illuminate\Http\RedirectResponse
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident` | **\App\Models\Incident** |  |




**Throws:**

- [`AuthorizationException`](../../../../Illuminate/Auth/Access/AuthorizationException.md)



***

### returnInvestigation



```php
public returnInvestigation(\App\Models\Incident $incident): \Illuminate\Http\RedirectResponse
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident` | **\App\Models\Incident** |  |




**Throws:**

- [`AuthorizationException`](../../../../Illuminate/Auth/Access/AuthorizationException.md)



***

### returnRCA



```php
public returnRCA(\App\Models\Incident $incident): \Illuminate\Http\RedirectResponse
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident` | **\App\Models\Incident** |  |




**Throws:**

- [`AuthorizationException`](../../../../Illuminate/Auth/Access/AuthorizationException.md)



***

### assignSupervisor



```php
public assignSupervisor(\Illuminate\Http\Request $request, \App\Models\Incident $incident): \Illuminate\Http\RedirectResponse
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | **\Illuminate\Http\Request** |  |
| `$incident` | **\App\Models\Incident** |  |




**Throws:**

- [`AuthorizationException`](../../../../Illuminate/Auth/Access/AuthorizationException.md)

- [`UserNotSupervisorException`](../../../Exceptions/UserNotSupervisorException.md)



***

### unassignSupervisor



```php
public unassignSupervisor(\App\Models\Incident $incident): \Illuminate\Http\RedirectResponse
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident` | **\App\Models\Incident** |  |




**Throws:**

- [`AuthorizationException`](../../../../Illuminate/Auth/Access/AuthorizationException.md)



***

### closeIncident



```php
public closeIncident(\App\Models\Incident $incident): \Illuminate\Http\RedirectResponse
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident` | **\App\Models\Incident** |  |




**Throws:**

- [`AuthorizationException`](../../../../Illuminate/Auth/Access/AuthorizationException.md)



***

### reopenIncident



```php
public reopenIncident(\App\Models\Incident $incident): \Illuminate\Http\RedirectResponse
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident` | **\App\Models\Incident** |  |




**Throws:**

- [`AuthorizationException`](../../../../Illuminate/Auth/Access/AuthorizationException.md)



***


***
> Automatically generated on 2025-03-10
