***

# IncidentCreated

StoredEvent should be inherited for all events
and their handle and react methods should be overloaded as needed.



* Full name: `\App\StorableEvents\Incident\IncidentCreated`
* Parent class: [`\App\StorableEvents\StoredEvent`](../StoredEvent.md)



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
public ?int $role
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
public \Carbon\Carbon $happened_at
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
public __construct(bool $anonymous, bool $on_behalf, bool $on_behalf_anonymous, ?int $role, ?string $last_name, ?string $first_name, ?string $upei_id, ?string $email, ?string $phone, bool $work_related, bool $workers_comp_submitted, \Carbon\Carbon $happened_at, ?string $location, ?string $room_number, ?array $witnesses, \App\Enum\IncidentType $incident_type, string $descriptor, ?string $description, ?string $injury_description, ?string $first_aid_description, ?string $reporters_email, ?string $supervisor_name): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$anonymous` | **bool** |  |
| `$on_behalf` | **bool** |  |
| `$on_behalf_anonymous` | **bool** |  |
| `$role` | **?int** |  |
| `$last_name` | **?string** |  |
| `$first_name` | **?string** |  |
| `$upei_id` | **?string** |  |
| `$email` | **?string** |  |
| `$phone` | **?string** |  |
| `$work_related` | **bool** |  |
| `$workers_comp_submitted` | **bool** |  |
| `$happened_at` | **\Carbon\Carbon** |  |
| `$location` | **?string** |  |
| `$room_number` | **?string** |  |
| `$witnesses` | **?array** |  |
| `$incident_type` | **\App\Enum\IncidentType** |  |
| `$descriptor` | **string** |  |
| `$description` | **?string** |  |
| `$injury_description` | **?string** |  |
| `$first_aid_description` | **?string** |  |
| `$reporters_email` | **?string** |  |
| `$supervisor_name` | **?string** |  |





***

### handle

Called by the projector.

```php
public handle(): void
```












***

### react

Called by the reactor.

```php
public react(): void
```

Will not be replayed on event replays.










***


## Inherited methods


### handle

Called by the projector.

```php
public handle(): void
```












***

### react

Called by the reactor.

```php
public react(): void
```

Will not be replayed on event replays.










***


***
> Automatically generated on 2025-03-07
