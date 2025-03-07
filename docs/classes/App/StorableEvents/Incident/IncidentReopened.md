***

# IncidentReopened

StoredEvent should be inherited for all events
and their handle and react methods should be overloaded as needed.



* Full name: `\App\StorableEvents\Incident\IncidentReopened`
* Parent class: [`\App\StorableEvents\StoredEvent`](../StoredEvent.md)



## Properties


### incident



```php
private ?\App\Models\Incident $incident
```






***

## Methods


### incident



```php
public incident(): mixed
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
