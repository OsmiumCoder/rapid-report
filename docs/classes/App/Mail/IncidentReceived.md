***

# IncidentReceived





* Full name: `\App\Mail\IncidentReceived`
* Parent class: [`Mailable`](../../Illuminate/Mail/Mailable.md)



## Properties


### url



```php
public string $url
```






***

### message



```php
public string $message
```






***

### incidentId



```php
public string $incidentId
```






***

## Methods


### __construct

Create a new message instance.

```php
public __construct(string $incidentId): mixed
```








**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$incidentId` | **string** |  |





***

### envelope

Get the message envelope.

```php
public envelope(): \Illuminate\Mail\Mailables\Envelope
```












***

### content

Get the message content definition.

```php
public content(): \Illuminate\Mail\Mailables\Content
```












***


***
> Automatically generated on 2025-03-10
