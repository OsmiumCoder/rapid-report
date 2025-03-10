***

# RootCauseAnalysisController





* Full name: `\App\Http\Controllers\RootCauseAnalysis\RootCauseAnalysisController`
* Parent class: [`\App\Http\Controllers\Controller`](../Controller.md)




## Methods


### create

Show the form for creating a new resource.

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

Store a newly created resource in storage.

```php
public store(\App\Models\Incident $incident, \App\Data\RootCauseAnalysisData $rcaData): \Illuminate\Http\RedirectResponse
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident` | **\App\Models\Incident** |  |
| `$rcaData` | **\App\Data\RootCauseAnalysisData** |  |




**Throws:**

- [`AuthorizationException`](../../../../Illuminate/Auth/Access/AuthorizationException.md)



***

### show

Display the specified resource.

```php
public show(\App\Models\Incident $incident, \App\Models\RootCauseAnalysis $rootCauseAnalysis): \Inertia\Response
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident` | **\App\Models\Incident** |  |
| `$rootCauseAnalysis` | **\App\Models\RootCauseAnalysis** |  |




**Throws:**

- [`AuthorizationException`](../../../../Illuminate/Auth/Access/AuthorizationException.md)



***


***
> Automatically generated on 2025-03-10
