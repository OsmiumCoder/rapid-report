***

# RootCauseAnalysisController





* Full name: `\App\Http\Controllers\RootCauseAnalysis\RootCauseAnalysisController`
* Parent class: [`\App\Http\Controllers\Controller`](../Controller.md)




## Methods


### create

Show the form for creating a new resource.

```php
public create(\App\Models\Incident $incident): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident` | **\App\Models\Incident** |  |





***

### store

Store a newly created resource in storage.

```php
public store(\App\Models\Incident $incident, \App\Data\RootCauseAnalysisData $rcaData): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident` | **\App\Models\Incident** |  |
| `$rcaData` | **\App\Data\RootCauseAnalysisData** |  |





***

### show

Display the specified resource.

```php
public show(\App\Models\Incident $incident, \App\Models\RootCauseAnalysis $rootCauseAnalysis): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident` | **\App\Models\Incident** |  |
| `$rootCauseAnalysis` | **\App\Models\RootCauseAnalysis** |  |





***

### edit

Show the form for editing the specified resource.

```php
public edit(\App\Models\RootCauseAnalysis $rootCauseAnalysis): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$rootCauseAnalysis` | **\App\Models\RootCauseAnalysis** |  |





***

### update

Update the specified resource in storage.

```php
public update(\Illuminate\Http\Request $request, \App\Models\RootCauseAnalysis $rootCauseAnalysis): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | **\Illuminate\Http\Request** |  |
| `$rootCauseAnalysis` | **\App\Models\RootCauseAnalysis** |  |





***

### destroy

Remove the specified resource from storage.

```php
public destroy(\App\Models\RootCauseAnalysis $rootCauseAnalysis): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$rootCauseAnalysis` | **\App\Models\RootCauseAnalysis** |  |





***


***
> Automatically generated on 2025-03-07
