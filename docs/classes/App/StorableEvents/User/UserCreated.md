***

# UserCreated

StoredEvent should be inherited for all events
and their handle and react methods should be overloaded as needed.



* Full name: `\App\StorableEvents\User\UserCreated`
* Parent class: [`\App\StorableEvents\StoredEvent`](../StoredEvent.md)



## Properties


### name



```php
public string $name
```






***

### email



```php
public string $email
```






***

### password



```php
public string $password
```






***

### upei_id



```php
public string $upei_id
```






***

### phone



```php
public string $phone
```






***

### role



```php
public \App\Enum\RolesEnum $role
```






***

### incident_id



```php
public ?string $incident_id
```






***

## Methods


### __construct



```php
public __construct(string $name, string $email, string $password, string $upei_id, string $phone, \App\Enum\RolesEnum $role, ?string $incident_id = null): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | **string** |  |
| `$email` | **string** |  |
| `$password` | **string** |  |
| `$upei_id` | **string** |  |
| `$phone` | **string** |  |
| `$role` | **\App\Enum\RolesEnum** |  |
| `$incident_id` | **?string** |  |





***

### handle

Called by the projector.

```php
public handle(): void
```











**Throws:**

- [`UserNotSupervisorException`](../../Exceptions/UserNotSupervisorException.md)



***

### react

Called by the reactor.

```php
public react(): void
```

In the event of an event replay code executed
within this method will not be replayed.










***


## Inherited methods


### handle

Called by the projector.

```php
public handle(): void
```












***

### react

Called by the reactor.

```php
public react(): void
```

In the event of an event replay code executed
within this method will not be replayed.










***


***
> Automatically generated on 2025-03-11
