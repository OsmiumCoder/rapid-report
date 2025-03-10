***

# RootCauseAnalysisData





* Full name: `\App\Data\RootCauseAnalysisData`
* Parent class: [`Data`](../../Spatie/LaravelData/Data.md)



## Properties


### individuals_involved



```php
public ?array $individuals_involved
```






***

### primary_effect



```php
public ?string $primary_effect
```






***

### whys



```php
public ?array $whys
```






***

### solutions_and_actions



```php
public ?array $solutions_and_actions
```






***

### peoples_positions



```php
public ?array $peoples_positions
```






***

### attention_to_work



```php
public ?array $attention_to_work
```






***

### communication



```php
public ?array $communication
```






***

### ppe_in_good_condition



```php
public ?bool $ppe_in_good_condition
```






***

### ppe_in_use



```php
public ?bool $ppe_in_use
```






***

### ppe_correct_type



```php
public ?bool $ppe_correct_type
```






***

### correct_tool_used



```php
public ?bool $correct_tool_used
```






***

### policies_followed



```php
public ?bool $policies_followed
```






***

### worked_safely



```php
public ?bool $worked_safely
```






***

### used_tool_properly



```php
public ?bool $used_tool_properly
```






***

### tool_in_good_condition



```php
public ?bool $tool_in_good_condition
```






***

### working_conditions



```php
public ?array $working_conditions
```






***

### root_causes



```php
public ?array $root_causes
```






***

## Methods


### __construct



```php
public __construct(?array $individuals_involved, ?string $primary_effect, ?array $whys, ?array $solutions_and_actions, ?array $peoples_positions, ?array $attention_to_work, ?array $communication, ?bool $ppe_in_good_condition, ?bool $ppe_in_use, ?bool $ppe_correct_type, ?bool $correct_tool_used, ?bool $policies_followed, ?bool $worked_safely, ?bool $used_tool_properly, ?bool $tool_in_good_condition, ?array $working_conditions, ?array $root_causes): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$individuals_involved` | **?array** |  |
| `$primary_effect` | **?string** |  |
| `$whys` | **?array** |  |
| `$solutions_and_actions` | **?array** |  |
| `$peoples_positions` | **?array** |  |
| `$attention_to_work` | **?array** |  |
| `$communication` | **?array** |  |
| `$ppe_in_good_condition` | **?bool** |  |
| `$ppe_in_use` | **?bool** |  |
| `$ppe_correct_type` | **?bool** |  |
| `$correct_tool_used` | **?bool** |  |
| `$policies_followed` | **?bool** |  |
| `$worked_safely` | **?bool** |  |
| `$used_tool_properly` | **?bool** |  |
| `$tool_in_good_condition` | **?bool** |  |
| `$working_conditions` | **?array** |  |
| `$root_causes` | **?array** |  |





***

### rules



```php
public static rules(\Spatie\LaravelData\Support\Validation\ValidationContext $context): array
```



* This method is **static**.




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$context` | **\Spatie\LaravelData\Support\Validation\ValidationContext** |  |





***

### messages



```php
public static messages(): array
```



* This method is **static**.








***


***
> Automatically generated on 2025-03-10
