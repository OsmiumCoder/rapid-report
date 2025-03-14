***

# Incident





* Full name: `\App\Models\Incident`
* Parent class: [`Model`](../../Illuminate/Database/Eloquent/Model.md)




## Methods


### boot



```php
protected static boot(): void
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
public toSearchableArray(): array
```












***

### supervisor



```php
public supervisor(): \Illuminate\Database\Eloquent\Relations\HasOne
```












***

### comments



```php
public comments(): \Illuminate\Database\Eloquent\Relations\MorphMany
```












***

### files



```php
public files(): \Illuminate\Database\Eloquent\Relations\MorphMany
```












***

### investigations



```php
public investigations(): \Illuminate\Database\Eloquent\Relations\HasMany
```












***

### rootCauseAnalyses



```php
public rootCauseAnalyses(): \Illuminate\Database\Eloquent\Relations\HasMany
```












***

### scopeFilter



```php
public scopeFilter(mixed $query, ?array $filters): void
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
> Automatically generated on 2025-03-14
