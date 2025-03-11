***

# IncidentSubmittedNotification





* Full name: `\App\Notifications\Incident\IncidentSubmittedNotification`
* Parent class: [`\App\Notifications\BaseNotification`](../BaseNotification.md)



## Properties


### incidentId



```php
public string $incidentId
```






***

### firstName



```php
public ?string $firstName
```






***

### lastName



```php
public ?string $lastName
```






***

## Methods


### __construct

Create a new notification instance.

```php
public __construct(string $incidentId, ?string $firstName, ?string $lastName): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incidentId` | **string** |  |
| `$firstName` | **?string** |  |
| `$lastName` | **?string** |  |





***

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

### toVonage

Get the Vonage / SMS representation of the notification.

```php
public toVonage(object $notifiable): \Illuminate\Notifications\Messages\VonageMessage
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$notifiable` | **object** |  |





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
> Automatically generated on 2025-03-11
