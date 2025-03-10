***

# SupervisorUnassigned

StoredEvent should be inherited for all events
and their handle and react methods should be overloaded as needed.



* Full name: `\App\StorableEvents\Incident\SupervisorUnassigned`
* Parent class: [`\App\StorableEvents\StoredEvent`](../StoredEvent.md)




## Methods


### handle

Called by the projector.

```php
public handle(): void
```











**Throws:**

- [`CouldNotPerformTransition`](../../../Spatie/ModelStates/Exceptions/CouldNotPerformTransition.md)



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
