***

# Incident





* Full name: `\App\Models\Incident`
* Parent class: [`Model`](../../Illuminate/Database/Eloquent/Model.md)




## Methods


### boot



```php
protected static boot(): mixed
```



* This method is **static**.








***

### getNextIdForYear



```php
private static getNextIdForYear(string $year): int
```



* This method is **static**.




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$year` | **string** |  |





***

### casts



```php
protected casts(): array
```












***

### toSearchableArray



```php
public toSearchableArray(): mixed
```












***

### supervisor



```php
public supervisor(): mixed
```












***

### comments



```php
public comments(): mixed
```












***

### files



```php
public files(): mixed
```












***

### investigations



```php
public investigations(): mixed
```












***

### rootCauseAnalyses



```php
public rootCauseAnalyses(): mixed
```












***

### scopeFilter



```php
public scopeFilter(mixed $query, ?array $filters): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$query` | **mixed** |  |
| `$filters` | **?array** |  |





***

### scopeSort



```php
public scopeSort(mixed $query, mixed $sortBy = &#039;created_at&#039;, mixed $sortDirection = &#039;asc&#039;): void
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$query` | **mixed** |  |
| `$sortBy` | **mixed** |  |
| `$sortDirection` | **mixed** |  |





***


***
> Automatically generated on 2025-03-07
