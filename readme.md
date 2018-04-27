# ResponseCRM PHP Wrapper

This is the unofficial PHP wrapper for ResponseCRM brought to you by [Affiliate Labs](https://affiliatelabs.com). 

For specific details on formatting your data for each method, please refer to the official [API documentation](http://developer.responsecrm.com).

## Installation

```
composer require affiliatelabs/responsecrm-php
```

## Usage

```php
<?php

use AffiliateLabs\ResponseCRM\ResponseCRM;

class Example
{
	public function test()
    {
    	$crm = new ResponseCRM('ApiGuid-Token');
        echo 'Authorization is ' . $crm->testAuth();
    }
}
```

## Available Methods

### Customers

##### addCustomer(array $data)

##### editCustomer($customerID, array $data)

##### editRecurring(array $customerIDs, $chargeID, array $data)

##### listRecurring($customerID)

##### addNote($customerID, $content)

##### listNotes($customerID)

##### markAsCancelled(array $customerIDs)

##### markAsChargeback($customerID)

### Fulfillment

##### listFulfillments($date)

##### updateTracking($transactionID, $trackingNumber)

### Leads

##### addLead(array $data)

##### listLeads()

### Sites

##### listSites()

### Testing

##### testAuth()

### Transactions

##### signup(array $data)

##### upsell(array $data)

##### refund($transactionID, $amount)

##### listTransactions($dateFrom, $dateTo)

### Webhooks

##### registerWebhook($siteID, $event, $payload)

##### deleteWebhook($webhookID)

##### listWebhooks($siteID)

##### webhookStats($webhookID)

## Contributing

Thank you for considering contributing to this wrapper for ResponseCRM. Pull requests are welcome and will be reviewed in a timely manner.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).