***

# HandleInertiaRequests





* Full name: `\App\Http\Middleware\HandleInertiaRequests`
* Parent class: [`Middleware`](../../../Inertia/Middleware.md)



## Properties


### rootView

The root template that is loaded on the first page visit.

```php
protected string $rootView
```






***

## Methods


### version

Determine the current asset version.

```php
public version(\Illuminate\Http\Request $request): ?string
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | **\Illuminate\Http\Request** |  |





***

### share

Define the props that are shared by default.

```php
public share(\Illuminate\Http\Request $request): array&lt;string,mixed&gt;
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | **\Illuminate\Http\Request** |  |





***


***
> Automatically generated on 2025-03-11
