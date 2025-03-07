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
public incident(): \App\Models\Incident
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
> Automatically generated on 2025-03-07
