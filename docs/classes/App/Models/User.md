***

# User





* Full name: `\App\Models\User`
* Parent class: [`User`](../../Illuminate/Foundation/Auth/User.md)



## Properties


### with

The relationships that should always be loaded.

```php
protected array $with
```






***

### fillable

The attributes that are mass assignable.

```php
protected array&lt;int,string&gt; $fillable
```






***

### hidden

The attributes that should be hidden for serialization.

```php
protected array&lt;int,string&gt; $hidden
```






***

## Methods


### casts

Get the attributes that should be cast.

```php
protected casts(): array&lt;string,string&gt;
```












***

### routeNotificationForVonage

Route notifications for the Vonage channel.

```php
public routeNotificationForVonage(\Illuminate\Notifications\Notification $notification): string
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$notification` | **\Illuminate\Notifications\Notification** |  |





***


***
> Automatically generated on 2025-03-11
