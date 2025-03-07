***

# RootCauseAnalysisPolicy





* Full name: `\App\Policies\RootCauseAnalysisPolicy`




## Methods


### viewAny

Determine whether the user can view any models.

```php
public viewAny(\App\Models\User $user): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |





***

### view

Determine whether the user can view the model.

```php
public view(\App\Models\User $user, \App\Models\RootCauseAnalysis $rootCauseAnalysis): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |
| `$rootCauseAnalysis` | **\App\Models\RootCauseAnalysis** |  |





***

### create

Determine whether the user can create models.

```php
public create(\App\Models\User $user, \App\Models\Incident $incident): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |
| `$incident` | **\App\Models\Incident** |  |





***

### update

Determine whether the user can update the model.

```php
public update(\App\Models\User $user, \App\Models\RootCauseAnalysis $rootCauseAnalysis): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |
| `$rootCauseAnalysis` | **\App\Models\RootCauseAnalysis** |  |





***

### delete

Determine whether the user can delete the model.

```php
public delete(\App\Models\User $user, \App\Models\RootCauseAnalysis $rootCauseAnalysis): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |
| `$rootCauseAnalysis` | **\App\Models\RootCauseAnalysis** |  |





***

### restore

Determine whether the user can restore the model.

```php
public restore(\App\Models\User $user, \App\Models\RootCauseAnalysis $rootCauseAnalysis): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |
| `$rootCauseAnalysis` | **\App\Models\RootCauseAnalysis** |  |





***

### forceDelete

Determine whether the user can permanently delete the model.

```php
public forceDelete(\App\Models\User $user, \App\Models\RootCauseAnalysis $rootCauseAnalysis): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |
| `$rootCauseAnalysis` | **\App\Models\RootCauseAnalysis** |  |





***


***
> Automatically generated on 2025-03-07
