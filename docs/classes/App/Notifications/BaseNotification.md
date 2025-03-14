***

# BaseNotification





* Full name: `\App\Notifications\BaseNotification`
* Parent class: [`Notification`](../../Illuminate/Notifications/Notification.md)
* This class implements:
[`\Illuminate\Contracts\Queue\ShouldQueue`](../../Illuminate/Contracts/Queue/ShouldQueue.md)
* This class is an **Abstract class**



## Properties


### message



```php
public string $message
```






***

### url



```php
public string $url
```






***

## Methods


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
