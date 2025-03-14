***

# IncidentsExport





* Full name: `\App\Exports\IncidentsExport`
* This class implements:
[`\Maatwebsite\Excel\Concerns\FromQuery`](../../Maatwebsite/Excel/Concerns/FromQuery.md), [`\Maatwebsite\Excel\Concerns\ShouldAutoSize`](../../Maatwebsite/Excel/Concerns/ShouldAutoSize.md), [`\Maatwebsite\Excel\Concerns\WithHeadings`](../../Maatwebsite/Excel/Concerns/WithHeadings.md), [`\Maatwebsite\Excel\Concerns\WithMapping`](../../Maatwebsite/Excel/Concerns/WithMapping.md)



## Properties


### exportData



```php
public \App\Data\IncidentExportData $exportData
```






***

## Methods


### __construct



```php
public __construct(\App\Data\IncidentExportData $exportData): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$exportData` | **\App\Data\IncidentExportData** |  |





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
public query(): \Illuminate\Database\Eloquent\Builder
```












***


***
> Automatically generated on 2025-03-14
