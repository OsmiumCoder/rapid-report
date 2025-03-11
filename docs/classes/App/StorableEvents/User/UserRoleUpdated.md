***

# UserRoleUpdated

StoredEvent should be inherited for all events
and their handle and react methods should be overloaded as needed.



* Full name: `\App\StorableEvents\User\UserRoleUpdated`
* Parent class: [`\App\StorableEvents\StoredEvent`](../StoredEvent.md)



## Properties


### user_id



```php
public int $user_id
```






***

### role



```php
public \App\Enum\RolesEnum $role
```






***

## Methods


### __construct



```php
public __construct(int $user_id, \App\Enum\RolesEnum $role): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user_id` | **int** |  |
| `$role` | **\App\Enum\RolesEnum** |  |





***

### handle

Called by the projector.

```php
public handle(): void
```












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
