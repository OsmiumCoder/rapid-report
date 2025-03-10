***

# InvestigationController





* Full name: `\App\Http\Controllers\Investigation\InvestigationController`
* Parent class: [`\App\Http\Controllers\Controller`](../Controller.md)




## Methods


### create

Show the form for creating a new investigation.

```php
public create(\App\Models\Incident $incident): \Inertia\Response
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident` | **\App\Models\Incident** |  |




**Throws:**

- [`AuthorizationException`](../../../../Illuminate/Auth/Access/AuthorizationException.md)



***

### store

Store a newly created investigation in storage.

```php
public store(\App\Models\Incident $incident, \App\Data\InvestigationData $investigationData): \Illuminate\Http\RedirectResponse
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident` | **\App\Models\Incident** |  |
| `$investigationData` | **\App\Data\InvestigationData** |  |




**Throws:**

- [`AuthorizationException`](../../../../Illuminate/Auth/Access/AuthorizationException.md)



***

### show

Display the specified investigation.

```php
public show(\App\Models\Incident $incident, \App\Models\Investigation $investigation): \Inertia\Response
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident` | **\App\Models\Incident** |  |
| `$investigation` | **\App\Models\Investigation** |  |




**Throws:**

- [`AuthorizationException`](../../../../Illuminate/Auth/Access/AuthorizationException.md)



***


***
> Automatically generated on 2025-03-10
