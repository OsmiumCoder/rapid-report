***

# UserPolicy





* Full name: `\App\Policies\UserPolicy`




## Methods


### create

Determine whether the user can create models.

```php
public create(\App\Models\User $user): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |





***

### delete

Determine whether the user can delete the model.

```php
public delete(\App\Models\User $user, \App\Models\User $model): bool
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |
| `$model` | **\App\Models\User** |  |





***

### updateRole



```php
public updateRole(\App\Models\User $user, \App\Models\User $model): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |
| `$model` | **\App\Models\User** |  |





***


***
> Automatically generated on 2025-03-10
