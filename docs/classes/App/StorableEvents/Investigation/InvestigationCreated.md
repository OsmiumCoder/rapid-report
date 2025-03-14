***

# InvestigationCreated

StoredEvent should be inherited for all events
and their handle and react methods should be overloaded as needed.



* Full name: `\App\StorableEvents\Investigation\InvestigationCreated`
* Parent class: [`\App\StorableEvents\StoredEvent`](../StoredEvent.md)



## Properties


### incident



```php
private ?\App\Models\Incident $incident
```






***

### incident_id



```php
public string $incident_id
```






***

### immediate_causes



```php
public ?string $immediate_causes
```






***

### basic_causes



```php
public ?string $basic_causes
```






***

### remedial_actions



```php
public string $remedial_actions
```






***

### prevention



```php
public ?string $prevention
```






***

### risk_rank



```php
public int $risk_rank
```






***

### resulted_in



```php
public array $resulted_in
```






***

### substandard_acts



```php
public ?array $substandard_acts
```






***

### substandard_conditions



```php
public ?array $substandard_conditions
```






***

### energy_transfer_causes



```php
public ?array $energy_transfer_causes
```






***

### personal_factors



```php
public ?array $personal_factors
```






***

### job_factors



```php
public ?array $job_factors
```






***

## Methods


### __construct



```php
public __construct(string $incident_id, ?string $immediate_causes, ?string $basic_causes, string $remedial_actions, ?string $prevention, int $risk_rank, array $resulted_in, ?array $substandard_acts, ?array $substandard_conditions, ?array $energy_transfer_causes, ?array $personal_factors, ?array $job_factors): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident_id` | **string** |  |
| `$immediate_causes` | **?string** |  |
| `$basic_causes` | **?string** |  |
| `$remedial_actions` | **string** |  |
| `$prevention` | **?string** |  |
| `$risk_rank` | **int** |  |
| `$resulted_in` | **array** |  |
| `$substandard_acts` | **?array** |  |
| `$substandard_conditions` | **?array** |  |
| `$energy_transfer_causes` | **?array** |  |
| `$personal_factors` | **?array** |  |
| `$job_factors` | **?array** |  |





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
> Automatically generated on 2025-03-14
