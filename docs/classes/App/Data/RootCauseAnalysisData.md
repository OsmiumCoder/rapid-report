***

# RootCauseAnalysisData

Request data for creation of a root cause analysis.

Rules method is overridden, and custom rules are merged with existing, inferred, rules.
All properties of this data is optional.

* Full name: `\App\Data\RootCauseAnalysisData`
* Parent class: [`Data`](../../Spatie/LaravelData/Data.md)

**See Also:**

* [`\App\Models\RootCauseAnalysis`](../Models/RootCauseAnalysis.md) - The model that will be created for this data.



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
public __construct(array&lt;int,array&lt;string,string&gt;&gt;|null $individuals_involved, string|null $primary_effect, string[]|null $whys, array&lt;int,array&lt;string,string&gt;&gt;|null $solutions_and_actions, string[]|null $peoples_positions, string[]|null $attention_to_work, string[]|null $communication, bool|null $ppe_in_good_condition, bool|null $ppe_in_use, bool|null $ppe_correct_type, bool|null $correct_tool_used, bool|null $policies_followed, bool|null $worked_safely, bool|null $used_tool_properly, bool|null $tool_in_good_condition, string[]|null $working_conditions, string[]|null $root_causes): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$individuals_involved` | **array<int,array<string,string>>&#124;null** | A list of the individuals that were deemed involved in the incident. |
| `$primary_effect` | **string&#124;null** | The primary effect that caused the incident. |
| `$whys` | **string[]&#124;null** | A list of the reasons why the incident likely occurred. |
| `$solutions_and_actions` | **array<int,array<string,string>>&#124;null** | A list of the solutions and corrective actions taken by the supervisor. |
| `$peoples_positions` | **string[]&#124;null** | A list of physical workplace conditions that if done correct may have prevented the incident. |
| `$attention_to_work` | **string[]&#124;null** | A list visual workplace conditions that if done correct may have prevented the incident. |
| `$communication` | **string[]&#124;null** | A list communication workplace conditions that if done correct may have prevented the incident. |
| `$ppe_in_good_condition` | **bool&#124;null** | If the PPE was in good condition prior to the incident. |
| `$ppe_in_use` | **bool&#124;null** | If PPE was in use during the incident. |
| `$ppe_correct_type` | **bool&#124;null** | If the correct PPE was used for the environment. |
| `$correct_tool_used` | **bool&#124;null** | If the correct tool for the job was used. |
| `$policies_followed` | **bool&#124;null** | If the correct workplace policies were followed. |
| `$worked_safely` | **bool&#124;null** | If the job was performed in a safe manner. |
| `$used_tool_properly` | **bool&#124;null** | If the tool used during the job was used properly. |
| `$tool_in_good_condition` | **bool&#124;null** | If the tool was in good condition prior to the incident. |
| `$working_conditions` | **string[]&#124;null** | A list physical workplace environment factors that if done correct may have prevented the incident. |
| `$root_causes` | **string[]&#124;null** | A list of the top 3 major contributing root causes to the incident. |





***

### rules

Provides the validation rules for the request.

```php
public static rules(): array
```

Each individual involved may contain a name email and phone,
all of which occur sometimes. Each solution and action may contain a cause,
control, remedial action, by whom, and by when.
All other arrays are arrays of only strings.

* This method is **static**.





**Return Value:**

The custom validation rules for request data.




***

### messages

Overridden validation messages.

```php
public static messages(): array
```



* This method is **static**.





**Return Value:**

The custom validation error messages.




***


***
> Automatically generated on 2025-03-11
