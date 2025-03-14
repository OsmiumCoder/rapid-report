***

# SupervisorAssignedNotification





* Full name: `\App\Notifications\Incident\SupervisorAssignedNotification`
* Parent class: [`\App\Notifications\BaseNotification`](../BaseNotification.md)



## Properties


### incidentSlug



```php
public string $incidentSlug
```






***

### supervisor



```php
public \App\Models\User $supervisor
```






***

### admin



```php
public \App\Models\User $admin
```






***

## Methods


### __construct

Create a new notification instance.

```php
public __construct(string $incidentSlug, \App\Models\User $supervisor, \App\Models\User $admin): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incidentSlug` | **string** |  |
| `$supervisor` | **\App\Models\User** |  |
| `$admin` | **\App\Models\User** |  |





***

### toMail

Get the mail representation of the notification.

```php
public toMail(object $notifiable): \Illuminate\Notifications\Messages\MailMessage
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$notifiable` | **object** |  |





***


## Inherited methods


### via

Get the notification's delivery channels.

```php
public via(object $notifiable): array&lt;int,string&gt;
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$notifiable` | **object** |  |





***

### toArray

Get the array representation of the notification.

```php
public toArray(object $notifiable): array&lt;string,mixed&gt;
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$notifiable` | **object** |  |





***


***
> Automatically generated on 2025-03-14
