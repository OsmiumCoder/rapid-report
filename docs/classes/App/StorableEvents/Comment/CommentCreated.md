***

# CommentCreated

StoredEvent should be inherited for all events
and their handle and react methods should be overloaded as needed.



* Full name: `\App\StorableEvents\Comment\CommentCreated`
* Parent class: [`\App\StorableEvents\StoredEvent`](../StoredEvent.md)



## Properties


### content



```php
public string $content
```






***

### type



```php
public \App\Enum\CommentType $type
```






***

### commentable_id



```php
public string $commentable_id
```






***

### commentable_type



```php
public string $commentable_type
```






***

## Methods


### __construct



```php
public __construct(string $content, \App\Enum\CommentType $type, string $commentable_id, string $commentable_type): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$content` | **string** |  |
| `$type` | **\App\Enum\CommentType** |  |
| `$commentable_id` | **string** |  |
| `$commentable_type` | **string** |  |





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
> Automatically generated on 2025-03-10
