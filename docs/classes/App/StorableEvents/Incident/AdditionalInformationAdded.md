***

# AdditionalInformationAdded

StoredEvent should be inherited for all events
and their handle and react methods should be overloaded as needed.



* Full name: `\App\StorableEvents\Incident\AdditionalInformationAdded`
* Parent class: [`\App\StorableEvents\StoredEvent`](../StoredEvent.md)



## Properties


### incident



```php
private ?\App\Models\Incident $incident
```






***

### additionalInformation



```php
public string $additionalInformation
```






***

## Methods


### __construct



```php
public __construct(string $additionalInformation): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$additionalInformation` | **string** |  |





***

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
