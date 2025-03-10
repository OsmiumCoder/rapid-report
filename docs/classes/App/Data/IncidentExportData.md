***

# IncidentExportData

Request data for incident export criteria.

Rules method is overridden, and custom rules are merged with existing, inferred, rules.

* Full name: `\App\Data\IncidentExportData`
* Parent class: [`Data`](../../Spatie/LaravelData/Data.md)



## Properties


### start



```php
public \Carbon\CarbonImmutable $start
```






***

### end



```php
public \Carbon\CarbonImmutable $end
```






***

### fields



```php
public array $fields
```






***

## Methods


### __construct



```php
public __construct(\Carbon\CarbonImmutable $start, \Carbon\CarbonImmutable $end, string[] $fields): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$start` | **\Carbon\CarbonImmutable** | The start date to export data for. |
| `$end` | **\Carbon\CarbonImmutable** | The end date to export data for. |
| `$fields` | **string[]** | The fields of the incident model to be exported. |





**See Also:**

* [`\App\Models\Incident`](../Models/Incident.md) - For a list of the incident fields.


***

### rules

Provides the validation rules for the request.

```php
public static rules(): array
```

$fields property must contain at least one element, and all elements must be distinct.
In addition, all elements of the array must be a valid incident field.

* This method is **static**.





**Return Value:**

The custom validation rules for request data.




***


***
> Automatically generated on 2025-03-10
