***

# AdditionalInformationNotification





* Full name: `\App\Notifications\Incident\AdditionalInformationNotification`
* Parent class: [`\App\Notifications\BaseNotification`](../BaseNotification.md)



## Properties


### incidentSlug



```php
public string $incidentSlug
```






***

### additionalInformation



```php
public string $additionalInformation
```






***

## Methods


### __construct



```php
public __construct(string $incidentSlug, string $additionalInformation): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incidentSlug` | **string** |  |
| `$additionalInformation` | **string** |  |





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
