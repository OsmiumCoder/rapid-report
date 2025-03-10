***

# ExportController





* Full name: `\App\Http\Controllers\Report\ExportController`
* Parent class: [`\App\Http\Controllers\Controller`](../Controller.md)




## Methods


### exportXLSX



```php
public exportXLSX(\App\Data\ExportData $exportData): \Symfony\Component\HttpFoundation\BinaryFileResponse
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$exportData` | **\App\Data\ExportData** |  |




**Throws:**

- [`AuthorizationException`](../../../../Illuminate/Auth/Access/AuthorizationException.md)

- [`Exception`](../../../../PhpOffice/PhpSpreadsheet/Exception.md)

- [`Exception`](../../../../PhpOffice/PhpSpreadsheet/Writer/Exception.md)



***

### exportCSV



```php
public exportCSV(\App\Data\ExportData $exportData): \Symfony\Component\HttpFoundation\BinaryFileResponse
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$exportData` | **\App\Data\ExportData** |  |




**Throws:**

- [`AuthorizationException`](../../../../Illuminate/Auth/Access/AuthorizationException.md)

- [`Exception`](../../../../PhpOffice/PhpSpreadsheet/Exception.md)

- [`Exception`](../../../../PhpOffice/PhpSpreadsheet/Writer/Exception.md)



***


***
> Automatically generated on 2025-03-10
