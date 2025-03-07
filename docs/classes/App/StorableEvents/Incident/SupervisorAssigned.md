***

# SupervisorAssigned

StoredEvent should be inherited for all events
and their handle and react methods should be overloaded as needed.



* Full name: `\App\StorableEvents\Incident\SupervisorAssigned`
* Parent class: [`\App\StorableEvents\StoredEvent`](../StoredEvent.md)



## Properties


### incident



```php
private ?\App\Models\Incident $incident
```






***

### supervisor



```php
private ?\App\Models\User $supervisor
```






***

### supervisor_id



```php
public int $supervisor_id
```






***

## Methods


### __construct



```php
public __construct(int $supervisor_id): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$supervisor_id` | **int** |  |





***

### incident



```php
public incident(): mixed
```












***

### supervisor



```php
public supervisor(): mixed
```












***

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

Will not be replayed on event replays.










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

Will not be replayed on event replays.










***


***
> Automatically generated on 2025-03-07
