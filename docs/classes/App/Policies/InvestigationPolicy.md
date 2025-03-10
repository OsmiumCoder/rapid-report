***

# InvestigationPolicy





* Full name: `\App\Policies\InvestigationPolicy`




## Methods


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


***
> Automatically generated on 2025-03-10
