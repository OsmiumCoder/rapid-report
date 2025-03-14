***

# IncidentPolicy





* Full name: `\App\Policies\IncidentPolicy`




## Methods


### viewAny

Determine whether the user can view any incidents.

```php
public viewAny(\App\Models\User $user): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |





***

### viewAnyAssigned



```php
public viewAnyAssigned(\App\Models\User $user): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |





***

### viewAnyOwned



```php
public viewAnyOwned(\App\Models\User $user): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |





***

### view

Determine whether the user can view the incident.

```php
public view(\App\Models\User $user, \App\Models\Incident $incident): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |
| `$incident` | **\App\Models\Incident** |  |





***

### performAdminActions



```php
public performAdminActions(\App\Models\User $user): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |





***

### requestReview



```php
public requestReview(\App\Models\User $user, \App\Models\Incident $incident): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |
| `$incident` | **\App\Models\Incident** |  |





***

### provideFollowUp



```php
public provideFollowUp(\App\Models\User $user, \App\Models\Incident $incident): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |
| `$incident` | **\App\Models\Incident** |  |





***

### addComment



```php
public addComment(\App\Models\User $user, \App\Models\Incident $incident): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |
| `$incident` | **\App\Models\Incident** |  |





***

### searchIncidents



```php
public searchIncidents(\App\Models\User $user, \Laravel\Scout\Builder $incidentQuery): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |
| `$incidentQuery` | **\Laravel\Scout\Builder** |  |





***

### addAdditionalInformation



```php
public addAdditionalInformation(\App\Models\User $user, \App\Models\Incident $incident): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |
| `$incident` | **\App\Models\Incident** |  |





***

### create

Determine whether the user can create incidents.

```php
public create(\App\Models\User $user): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |





***

### downloadFiles



```php
public downloadFiles(\App\Models\User $user, \App\Models\File $file): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |
| `$file` | **\App\Models\File** |  |





***


***
> Automatically generated on 2025-03-14
