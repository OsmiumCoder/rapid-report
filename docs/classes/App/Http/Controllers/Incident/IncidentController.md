***

# IncidentController





* Full name: `\App\Http\Controllers\Incident\IncidentController`
* Parent class: [`\App\Http\Controllers\Controller`](../Controller.md)




## Methods


### index

Display a listing of the Incident.

```php
public index(\Illuminate\Http\Request $request): \Inertia\Response
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | **\Illuminate\Http\Request** |  |




**Throws:**

- [`AuthorizationException`](../../../../Illuminate/Auth/Access/AuthorizationException.md)



***

### create

Show the form for creating a new Incident.

```php
public create(): \Inertia\Response
```












***

### store

Store a newly created Incident in storage.

```php
public store(\App\Data\IncidentData $incidentData): \Inertia\Response
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incidentData` | **\App\Data\IncidentData** |  |





***

### show

Display the specified Incident.

```php
public show(\App\Models\Incident $incident): \Inertia\Response
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident` | **\App\Models\Incident** |  |




**Throws:**

- [`AuthorizationException`](../../../../Illuminate/Auth/Access/AuthorizationException.md)



***


***
> Automatically generated on 2025-03-14
