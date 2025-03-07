***

# StoredEvent

StoredEvent should be inherited for all events
and their handle and react methods should be overloaded as needed.



* Full name: `\App\StorableEvents\StoredEvent`
* Parent class: [`ShouldBeStored`](../../Spatie/EventSourcing/StoredEvents/ShouldBeStored.md)
* This class is an **Abstract class**




## Methods


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
