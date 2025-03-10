***

# NewPasswordController





* Full name: `\App\Http\Controllers\Auth\NewPasswordController`
* Parent class: [`\App\Http\Controllers\Controller`](../Controller.md)




## Methods


### create

Display the password reset view.

```php
public create(\Illuminate\Http\Request $request): \Inertia\Response
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | **\Illuminate\Http\Request** |  |





***

### store

Handle an incoming new password request.

```php
public store(\Illuminate\Http\Request $request): \Illuminate\Http\RedirectResponse
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | **\Illuminate\Http\Request** |  |




**Throws:**

- [`ValidationException`](../../../../Illuminate/Validation/ValidationException.md)



***


***
> Automatically generated on 2025-03-10
