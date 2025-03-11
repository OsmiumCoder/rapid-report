***

# FileCreated

StoredEvent should be inherited for all events
and their handle and react methods should be overloaded as needed.



* Full name: `\App\StorableEvents\Incident\FileCreated`
* Parent class: [`\App\StorableEvents\StoredEvent`](../StoredEvent.md)



## Properties


### name



```php
public string $name
```






***

### original_name



```php
public string $original_name
```






***

### path



```php
public string $path
```






***

### size



```php
public int $size
```






***

### mime_type



```php
public string $mime_type
```






***

### extension



```php
public string $extension
```






***

### fileable_id



```php
public string $fileable_id
```






***

### fileable_type



```php
public string $fileable_type
```






***

## Methods


### __construct



```php
public __construct(string $name, string $original_name, string $path, int $size, string $mime_type, string $extension, string $fileable_id, string $fileable_type): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | **string** |  |
| `$original_name` | **string** |  |
| `$path` | **string** |  |
| `$size` | **int** |  |
| `$mime_type` | **string** |  |
| `$extension` | **string** |  |
| `$fileable_id` | **string** |  |
| `$fileable_type` | **string** |  |





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
