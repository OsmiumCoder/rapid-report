***

# RootCauseAnalysisAggregateRoot

Handles all events related to root cause analyses.



* Full name: `\App\Aggregates\RootCauseAnalysisAggregateRoot`
* Parent class: [`AggregateRoot`](../../Spatie/EventSourcing/AggregateRoots/AggregateRoot.md)

**See Also:**

* [`\App\Models\RootCauseAnalysis`](../Models/RootCauseAnalysis.md) - The model that is being aggregated.




## Methods


### createRootCauseAnalysis

Records an RootCauseAnalysisCreated event.

```php
public createRootCauseAnalysis(\App\Data\RootCauseAnalysisData $investigationData, \App\Models\Incident $incident): $this
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$investigationData` | **\App\Data\RootCauseAnalysisData** | The request data for the new root cause analysis. |
| `$incident` | **\App\Models\Incident** | The Incident in which to attach the root cause analysis to. |





**See Also:**

* [`\App\StorableEvents\RootCauseAnalysis\RootCauseAnalysisCreated`](../StorableEvents/RootCauseAnalysis/RootCauseAnalysisCreated.md) - The event recorded by this method.


***


***
> Automatically generated on 2025-03-14
