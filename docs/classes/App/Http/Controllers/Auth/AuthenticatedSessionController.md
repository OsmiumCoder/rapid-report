***

# AuthenticatedSessionController





* Full name: `\App\Http\Controllers\Auth\AuthenticatedSessionController`
* Parent class: [`\App\Http\Controllers\Controller`](../Controller.md)




## Methods


### create

Display the login view.

```php
public create(): \Inertia\Response
```












***

### store

Handle an incoming authentication request.

```php
public store(\App\Http\Requests\Auth\LoginRequest $request): \Illuminate\Http\RedirectResponse
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | **\App\Http\Requests\Auth\LoginRequest** |  |





***

### destroy

Destroy an authenticated session.

```php
public destroy(\Illuminate\Http\Request $request): \Illuminate\Http\RedirectResponse
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | **\Illuminate\Http\Request** |  |





***


***
> Automatically generated on 2025-03-07
