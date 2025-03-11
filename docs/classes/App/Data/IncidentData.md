***

# IncidentData

Request data for creation of an incident.



* Full name: `\App\Data\IncidentData`
* Parent class: [`Data`](../../Spatie/LaravelData/Data.md)

**See Also:**

* [`\App\Models\Incident`](../Models/Incident.md) - The model that will be created for this data.



## Properties


### anonymous



```php
public bool $anonymous
```






***

### on_behalf



```php
public bool $on_behalf
```






***

### on_behalf_anonymous



```php
public bool $on_behalf_anonymous
```






***

### role



```php
public ?\App\Enum\RoleType $role
```






***

### last_name



```php
public ?string $last_name
```






***

### first_name



```php
public ?string $first_name
```






***

### upei_id



```php
public ?string $upei_id
```






***

### email



```php
public ?string $email
```






***

### phone



```php
public ?string $phone
```






***

### work_related



```php
public bool $work_related
```






***

### workers_comp_submitted



```php
public bool $workers_comp_submitted
```






***

### happened_at



```php
public ?\Carbon\Carbon $happened_at
```






***

### location



```php
public ?string $location
```






***

### room_number



```php
public ?string $room_number
```






***

### witnesses



```php
public ?array $witnesses
```






***

### incident_type



```php
public \App\Enum\IncidentType $incident_type
```






***

### descriptor



```php
public string $descriptor
```






***

### description



```php
public ?string $description
```






***

### injury_description



```php
public ?string $injury_description
```






***

### first_aid_description



```php
public ?string $first_aid_description
```






***

### reporters_email



```php
public ?string $reporters_email
```






***

### supervisor_name



```php
public ?string $supervisor_name
```






***

## Methods


### __construct



```php
public __construct(bool $anonymous, bool $on_behalf, bool $on_behalf_anonymous, \App\Enum\RoleType|null $role, string|null $last_name, string|null $first_name, string|null $upei_id, string|null $email, string|null $phone, bool $work_related, bool $workers_comp_submitted, \Carbon\Carbon|null $happened_at, string|null $location, string|null $room_number, array&lt;int,array&lt;string,string&gt;&gt;|null $witnesses, \App\Enum\IncidentType $incident_type, string $descriptor, string|null $description, string|null $injury_description, string|null $first_aid_description, string|null $reporters_email, string|null $supervisor_name): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$anonymous` | **bool** | If the reporter of this incident is remaining anonymous. |
| `$on_behalf` | **bool** | If the reporter is reporting for themselves or for someone else. |
| `$on_behalf_anonymous` | **bool** | If the incident is about someone who is not the reporter and wants to be anonymous. |
| `$role` | **\App\Enum\RoleType&#124;null** | Optional. The role of the individual involved in the incident. |
| `$last_name` | **string&#124;null** | Optional. The last name of the individual involved in the incident. |
| `$first_name` | **string&#124;null** | Optional. The first name of the individual involved in the incident. |
| `$upei_id` | **string&#124;null** | Optional. The UPEI ID number of the individual involved in the incident. |
| `$email` | **string&#124;null** | Optional. The email of the individual involved in the incident. |
| `$phone` | **string&#124;null** | Optional. The phone number of the individual involved in the incident. |
| `$work_related` | **bool** | If the incident was related to workplace conditions. |
| `$workers_comp_submitted` | **bool** | If the individual involved submitted workers compensation. |
| `$happened_at` | **\Carbon\Carbon&#124;null** | Optional. The date on which the incident occurred. |
| `$location` | **string&#124;null** | Optional. The location of the incident. |
| `$room_number` | **string&#124;null** | Optional. The room number or general area of the incident within the location. |
| `$witnesses` | **array<int,array<string,string>>&#124;null** | Optional. The list of witnesses to the incident. Each witness has a name and optionally an email and phone. |
| `$incident_type` | **\App\Enum\IncidentType** | The category or type of incident. |
| `$descriptor` | **string** | The descriptor chosen based on the incident type. |
| `$description` | **string&#124;null** | Optional. The general description of the incident. |
| `$injury_description` | **string&#124;null** | Optional. The description of any injuries that occurred. |
| `$first_aid_description` | **string&#124;null** | Optional. The description of any first aid that was administered. |
| `$reporters_email` | **string&#124;null** | Optional. The email of the reporter. Will not be present if they remain anonymous. |
| `$supervisor_name` | **string&#124;null** | Optional. The supervisor that was given on submission. |





***


***
> Automatically generated on 2025-03-11
