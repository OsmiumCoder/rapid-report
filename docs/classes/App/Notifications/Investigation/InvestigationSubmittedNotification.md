***

# InvestigationSubmittedNotification





* Full name: `\App\Notifications\Investigation\InvestigationSubmittedNotification`
* Parent class: [`\App\Notifications\BaseNotification`](../BaseNotification.md)



## Properties


### incidentSlug



```php
public string $incidentSlug
```






***

### investigationId



```php
public string $investigationId
```






***

### supervisor



```php
public \App\Models\User $supervisor
```






***

## Methods


### __construct

Create a new notification instance.

```php
public __construct(string $incidentSlug, string $investigationId, \App\Models\User $supervisor): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incidentSlug` | **string** |  |
| `$investigationId` | **string** |  |
| `$supervisor` | **\App\Models\User** |  |





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
> Automatically generated on 2025-03-10
