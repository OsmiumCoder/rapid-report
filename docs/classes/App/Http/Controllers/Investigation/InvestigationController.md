***

# InvestigationController





* Full name: `\App\Http\Controllers\Investigation\InvestigationController`
* Parent class: [`\App\Http\Controllers\Controller`](../Controller.md)




## Methods


### create

Show the form for creating a new investigation.

```php
public create(\App\Models\Incident $incident): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident` | **\App\Models\Incident** |  |





***

### store

Store a newly created investigation in storage.

```php
public store(\App\Models\Incident $incident, \App\Data\InvestigationData $investigationData): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident` | **\App\Models\Incident** |  |
| `$investigationData` | **\App\Data\InvestigationData** |  |





***

### show

Display the specified investigation.

```php
public show(\App\Models\Incident $incident, \App\Models\Investigation $investigation): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident` | **\App\Models\Incident** |  |
| `$investigation` | **\App\Models\Investigation** |  |





***

### edit

Show the form for editing the specified investigation.

```php
public edit(\App\Models\Investigation $investigation): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$investigation` | **\App\Models\Investigation** |  |





***

### update

Update the specified investigation in storage.

```php
public update(\Illuminate\Http\Request $request, \App\Models\Investigation $investigation): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | **\Illuminate\Http\Request** |  |
| `$investigation` | **\App\Models\Investigation** |  |





***

### destroy

Remove the specified investigation from storage.

```php
public destroy(\App\Models\Investigation $investigation): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$investigation` | **\App\Models\Investigation** |  |





***


***
> Automatically generated on 2025-03-07
