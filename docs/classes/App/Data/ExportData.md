***

# ExportData





* Full name: `\App\Data\ExportData`
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
public __construct(\Carbon\CarbonImmutable $start, \Carbon\CarbonImmutable $end, array $fields): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$start` | **\Carbon\CarbonImmutable** |  |
| `$end` | **\Carbon\CarbonImmutable** |  |
| `$fields` | **array** |  |





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


***
> Automatically generated on 2025-03-07
