***

# InvestigationAggregateRoot

Handles all events related to investigations.



* Full name: `\App\Aggregates\InvestigationAggregateRoot`
* Parent class: [`AggregateRoot`](../../Spatie/EventSourcing/AggregateRoots/AggregateRoot.md)

**See Also:**

* [`\App\Models\Investigation`](../Models/Investigation.md) - The model that is being aggregated.




## Methods


### createInvestigation

Records an InvestigationCreated event.

```php
public createInvestigation(\App\Data\InvestigationData $investigationData, \App\Models\Incident $incident): $this
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$investigationData` | **\App\Data\InvestigationData** | The request data for the new investigation. |
| `$incident` | **\App\Models\Incident** | The Incident in which to attach the Investigation to. |





**See Also:**

* [`\App\StorableEvents\Investigation\InvestigationCreated`](../StorableEvents/Investigation/InvestigationCreated.md) - The event recorded by this method.

***


***
> Automatically generated on 2025-03-10
