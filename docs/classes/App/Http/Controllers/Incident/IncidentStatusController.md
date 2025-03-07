***

# IncidentStatusController





* Full name: `\App\Http\Controllers\Incident\IncidentStatusController`
* Parent class: [`\App\Http\Controllers\Controller`](../Controller.md)




## Methods


### requestReview



```php
public requestReview(\App\Models\Incident $incident): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident` | **\App\Models\Incident** |  |





***

### returnInvestigation



```php
public returnInvestigation(\App\Models\Incident $incident): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident` | **\App\Models\Incident** |  |





***

### returnRCA



```php
public returnRCA(\App\Models\Incident $incident): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident` | **\App\Models\Incident** |  |





***

### assignSupervisor



```php
public assignSupervisor(\Illuminate\Http\Request $request, \App\Models\Incident $incident): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | **\Illuminate\Http\Request** |  |
| `$incident` | **\App\Models\Incident** |  |





***

### unassignSupervisor



```php
public unassignSupervisor(\App\Models\Incident $incident): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident` | **\App\Models\Incident** |  |





***

### closeIncident



```php
public closeIncident(\App\Models\Incident $incident): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident` | **\App\Models\Incident** |  |





***

### reopenIncident



```php
public reopenIncident(\App\Models\Incident $incident): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident` | **\App\Models\Incident** |  |





***


***
> Automatically generated on 2025-03-07
