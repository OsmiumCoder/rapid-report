***

# IncidentFileController





* Full name: `\App\Http\Controllers\Incident\IncidentFileController`
* Parent class: [`\App\Http\Controllers\Controller`](../Controller.md)




## Methods


### upload



```php
public upload(\Illuminate\Http\Request $request, \App\Models\Incident $incident): \Illuminate\Http\RedirectResponse
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | **\Illuminate\Http\Request** |  |
| `$incident` | **\App\Models\Incident** |  |




**Throws:**

- [`AuthorizationException`](../../../../Illuminate/Auth/Access/AuthorizationException.md)



***

### download



```php
public download(\App\Models\Incident $incident, \App\Models\File $file): \Symfony\Component\HttpFoundation\StreamedResponse
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incident` | **\App\Models\Incident** |  |
| `$file` | **\App\Models\File** |  |





***


***
> Automatically generated on 2025-03-14
