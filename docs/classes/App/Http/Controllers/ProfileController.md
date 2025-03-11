***

# ProfileController





* Full name: `\App\Http\Controllers\ProfileController`
* Parent class: [`\App\Http\Controllers\Controller`](./Controller.md)




## Methods


### edit

Display the user's profile form.

```php
public edit(\Illuminate\Http\Request $request): \Inertia\Response
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | **\Illuminate\Http\Request** |  |





***

### update

Update the user's profile information.

```php
public update(\App\Http\Requests\ProfileUpdateRequest $request): \Illuminate\Http\RedirectResponse
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | **\App\Http\Requests\ProfileUpdateRequest** |  |





***

### destroy

Delete the user's account.

```php
public destroy(\Illuminate\Http\Request $request): \Illuminate\Http\RedirectResponse
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | **\Illuminate\Http\Request** |  |





***


***
> Automatically generated on 2025-03-11
