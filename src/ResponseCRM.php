<?php

namespace AffiliateLabs\ResponseCRM;

use Zttp\Zttp;

class ResponseCRM
{
	protected $api_guid;

	protected $base = 'https://openapi.responsecrm.com/api/v2/open/';

	public function __construct($api_guid)
	{
		$this->api_guid = $api_guid;
	}

	private function getAuthHeader()
	{
		return ['Authorization' => 'ApiGuid ' . $this->api_guid];
	}

	// LEADS
	public function addLead(array $data)
	{
		$endpoint = 'leads';
		return Zttp::withHeaders($this->getAuthHeader())->post($this->base . $endpoint, $data)->json();
	}

	public function listLeads()
	{
		$endpoint = 'leads';
		return Zttp::withHeaders($this->getAuthHeader())->get($this->base . $endpoint)->json();
	}

	// FULFILLMENT
	public function listFulfillments($date)
	{
		$endpoint = 'fulfillment-orders';
		return Zttp::withHeaders($this->getAuthHeader())->get($this->base . $endpoint, ['dateFrom' => strtotime($date)])->json();
	}

	public function updateTracking($transactionID, $trackingNumber)
	{
		$endpoint = 'fulfillment-orders';
		return Zttp::withHeaders($this->getAuthHeader())->put($this->base . $endpoint, ['Rows' => ['TransactionID' => $transactionID, 'TrackingNo' => $trackingNumber]])->json();
	}

	// CUSTOMER
	public function addCustomer(array $data)
	{
		$endpoint = 'customers';
		return Zttp::withHeaders($this->getAuthHeader())->post($this->base . $endpoint, $data)->json();
	}

	public function editCustomer($customerID, array $data)
	{
		$endpoint = 'customers/' . $customerID;
		return Zttp::withHeaders($this->getAuthHeader())->put($this->base . $endpoint, $data)->json();
	}

	public function editRecurring(array $customerIDs, $chargeID, array $data)
	{
		$endpoint = 'customers/recurrings';
		return Zttp::withHeaders($this->getAuthHeader())->put($this->base . $endpoint, [
			'CustomerIDs' => $customerIDs,
			'RecurringChargeID' => $chargeID,
			'NewValues' => $data
		])->json();
	}

	public function listRecurring($customerID)
	{
		$endpoint = 'customers/recurrings/' . $customerID;
		return Zttp::withHeaders($this->getAuthHeader())->get($this->base . $endpoint)->json();
	}

	public function addNote($customerID, $content)
	{
		$endpoint = 'customers/notes/' . $customerID;
		return Zttp::withHeaders($this->getAuthHeader())->post($this->base . $endpoint, ['Note' => $content])->json();
	}

	public function listNotes($customerID)
	{
		$endpoint = 'customers/notes/' . $customerID;
		return Zttp::withHeaders($this->getAuthHeader())->get($this->base . $endpoint)->json();
	}

	public function markAsCancelled(array $customerIDs)
	{
		$endpoint = 'customers/mark-cancelled/';
		return Zttp::withHeaders($this->getAuthHeader())->post($this->base . $endpoint, ['CustomerIDs' => $customerIDs])->json();
	}

	public function markAsChargeback($customerID)
	{
		$endpoint = 'customers/mark-chargeback/' . $customerID;
		return Zttp::withHeaders($this->getAuthHeader())->post($this->base . $endpoint)->json();
	}

	// TRANSACTIONS
	public function signup(array $data)
	{
		$endpoint = 'transactions';
		return Zttp::withHeaders($this->getAuthHeader())->post($this->base . $endpoint, $data)->json();
	}

	public function upsell(array $data)
	{
		$endpoint = 'transactions/upsell';
		return Zttp::withHeaders($this->getAuthHeader())->post($this->base . $endpoint, $data)->json();
	}

	public function refund($transactionID, $amount)
	{
		$endpoint = 'customer/refund';
		return Zttp::withHeaders($this->getAuthHeader())->post($this->base . $endpoint, [
			'TransactionID' => $transactionID,
			'Amount' => $amount
		])->json();
	}

	public function listTransactions(array $filters)
	{
		$endpoint = 'transactions';
		return Zttp::withHeaders($this->getAuthHeader())->get($this->base . $endpoint, $filters)->json();
	}

	// SITES
	public function listSites()
	{
		$endpoint = 'sites';
		return Zttp::withHeaders($this->getAuthHeader())->get($this->base . $endpoint)->json();
	}

	// WEBHOOKS
	public function registerWebhook($siteID, $event, $payload)
	{
		$endpoint = 'webhooks';
		return Zttp::withHeaders($this->getAuthHeader())->post($this->base . $endpoint, [
			'SiteID' => $siteID,
			'Event' => $event,
			'PayloadURL' => $payload
		])->json();
	}

	public function deleteWebhook($webhookID)
	{
		$endpoint = 'webhooks/' . $webhookID;
		return Zttp::withHeaders($this->getAuthHeader())->delete($this->base . $endpoint)->json();
	}

	public function listWebhooks($siteID)
	{
		$endpoint = 'webhooks/' . $siteID;
		return Zttp::withHeaders($this->getAuthHeader())->get($this->base . $endpoint)->json();
	}

	public function webhookStats($webhookID)
	{
		$endpoint = 'webhooks/stats/' . $webhookID;
		return Zttp::withHeaders($this->getAuthHeader())->get($this->base . $endpoint)->json();
	}

	// TESTING
	public function testAuth()
	{
		$endpoint = 'test-auth';
		$response = Zttp::withHeaders($this->getAuthHeader())->get($this->base . $endpoint)->json();
		if($response['Status'] == 0) {
			return 'valid';
		} else {
			return 'invalid';
		}
	}
	
	//PAYPAL
	public function createPayment(array $data)
	{
		$endpoint = 'transactions/paypal/create-payment';
		return Zttp::withHeaders($this->getAuthHeader())->post($this->base . $endpoint, $data)->json();
	}
	
	public function executePayment(array $data)
	{
		$endpoint = 'transactions/paypal/execute-payment';
		return Zttp::withHeaders($this->getAuthHeader())->post($this->base . $endpoint, $data)->json();
	}
}
