***

# LoginRequest





* Full name: `\App\Http\Requests\Auth\LoginRequest`
* Parent class: [`FormRequest`](../../../../Illuminate/Foundation/Http/FormRequest.md)




## Methods


### authorize

Determine if the user is authorized to make this request.

```php
public authorize(): bool
```












***

### rules

Get the validation rules that apply to the request.

```php
public rules(): array&lt;string,\Illuminate\Contracts\Validation\ValidationRule|array|string&gt;
```












***

### authenticate

Attempt to authenticate the request's credentials.

```php
public authenticate(): void
```











**Throws:**

- [`ValidationException`](../../../../Illuminate/Validation/ValidationException.md)



***

### ensureIsNotRateLimited

Ensure the login request is not rate limited.

```php
public ensureIsNotRateLimited(): void
```











**Throws:**

- [`ValidationException`](../../../../Illuminate/Validation/ValidationException.md)



***

### throttleKey

Get the rate limiting throttle key for the request.

```php
public throttleKey(): string
```












***


***
> Automatically generated on 2025-03-11
