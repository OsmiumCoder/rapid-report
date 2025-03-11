***

# InvestigationData

Request data for creation of an investigation.



* Full name: `\App\Data\InvestigationData`
* Parent class: [`Data`](../../Spatie/LaravelData/Data.md)

**See Also:**

* [`\App\Models\Investigation`](../Models/Investigation.md) - The model that will be created for this data.



## Properties


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
public __construct(string|null $immediate_causes, string|null $basic_causes, string $remedial_actions, string|null $prevention, int $risk_rank, array $resulted_in, array|null $substandard_acts, array|null $substandard_conditions, array|null $energy_transfer_causes, array|null $personal_factors, array|null $job_factors): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$immediate_causes` | **string&#124;null** | Optional. The immediate causes the supervisor attributed the incident to. |
| `$basic_causes` | **string&#124;null** | Optional. The basic causes the supervisor attributed the incident to. |
| `$remedial_actions` | **string** | The remedial actions the supervisor took to deal with the incident. |
| `$prevention` | **string&#124;null** | Optional. The preventive measures that were taken as a result of the incident. |
| `$risk_rank` | **int** | The Risk Ranking that was determined for the situation. |
| `$resulted_in` | **array** | The result of the incident occurring and how it affected all parties. |
| `$substandard_acts` | **array&#124;null** | Optional. Factors deemed as substandard acts that contributed to the incident. |
| `$substandard_conditions` | **array&#124;null** | Optional. Factors deemed as substandard conditions that contributed to the incident. |
| `$energy_transfer_causes` | **array&#124;null** | Optional. Physical exertion factors that contributed to the incident. |
| `$personal_factors` | **array&#124;null** | Optional. Factors related to the individuals state that contributed to the incident. |
| `$job_factors` | **array&#124;null** | Optional. Factors related to the workplace environment that contributed to the incident. |





***


***
> Automatically generated on 2025-03-11
