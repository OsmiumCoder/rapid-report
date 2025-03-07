***

# IncidentsExport





* Full name: `\App\Exports\IncidentsExport`
* This class implements:
[`\Maatwebsite\Excel\Concerns\FromQuery`](../../Maatwebsite/Excel/Concerns/FromQuery.md), [`\Maatwebsite\Excel\Concerns\ShouldAutoSize`](../../Maatwebsite/Excel/Concerns/ShouldAutoSize.md), [`\Maatwebsite\Excel\Concerns\WithHeadings`](../../Maatwebsite/Excel/Concerns/WithHeadings.md), [`\Maatwebsite\Excel\Concerns\WithMapping`](../../Maatwebsite/Excel/Concerns/WithMapping.md)



## Properties


### exportData



```php
public \App\Data\ExportData $exportData
```






***

## Methods


### __construct



```php
public __construct(\App\Data\ExportData $exportData): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$exportData` | **\App\Data\ExportData** |  |





***

### headings



```php
public headings(): array
```












***

### map



```php
public map(\App\Models\Incident $row): array
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$row` | **\App\Models\Incident** |  |





***

### query



```php
public query(): mixed
```












***


***
> Automatically generated on 2025-03-07
