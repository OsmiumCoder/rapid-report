***

# UserController





* Full name: `\App\Http\Controllers\User\UserController`
* Parent class: [`\App\Http\Controllers\Controller`](../Controller.md)




## Methods


### store

Store a newly created user in storage.

```php
public store(\Illuminate\Http\Request $request): \Illuminate\Http\RedirectResponse
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | **\Illuminate\Http\Request** |  |




**Throws:**

- [`AuthorizationException`](../../../../Illuminate/Auth/Access/AuthorizationException.md)



***

### destroy

Remove the specified user from storage.

```php
public destroy(\App\Models\User $user): \Illuminate\Http\RedirectResponse
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user` | **\App\Models\User** |  |




**Throws:**

- [`AuthorizationException`](../../../../Illuminate/Auth/Access/AuthorizationException.md)



***


***
> Automatically generated on 2025-03-07
