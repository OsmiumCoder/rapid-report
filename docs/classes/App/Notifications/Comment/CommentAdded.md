***

# CommentAdded





* Full name: `\App\Notifications\Comment\CommentAdded`
* Parent class: [`\App\Notifications\BaseNotification`](../BaseNotification.md)



## Properties


### comment



```php
public string $comment
```






***

### user



```php
public \App\Models\User $user
```






***

### url



```php
public string $url
```






***

### incidentSlug



```php
public string $incidentSlug
```






***

## Methods


### __construct

Create a new notification instance.

```php
public __construct(string $comment, \App\Models\User $user, string $url, string $incidentSlug): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$comment` | **string** |  |
| `$user` | **\App\Models\User** |  |
| `$url` | **string** |  |
| `$incidentSlug` | **string** |  |





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
