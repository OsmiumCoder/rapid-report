***

# InvestigationPolicy





* Full name: `\App\Policies\InvestigationPolicy`




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
public view(\App\Models\User $user, \App\Models\Investigation $investigation): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |
| `$investigation` | **\App\Models\Investigation** |  |





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
public update(\App\Models\User $user, \App\Models\Investigation $investigation): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |
| `$investigation` | **\App\Models\Investigation** |  |





***

### delete

Determine whether the user can delete the model.

```php
public delete(\App\Models\User $user, \App\Models\Investigation $investigation): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |
| `$investigation` | **\App\Models\Investigation** |  |





***

### restore

Determine whether the user can restore the model.

```php
public restore(\App\Models\User $user, \App\Models\Investigation $investigation): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |
| `$investigation` | **\App\Models\Investigation** |  |





***

### forceDelete

Determine whether the user can permanently delete the model.

```php
public forceDelete(\App\Models\User $user, \App\Models\Investigation $investigation): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |
| `$investigation` | **\App\Models\Investigation** |  |





***


***
> Automatically generated on 2025-03-07
