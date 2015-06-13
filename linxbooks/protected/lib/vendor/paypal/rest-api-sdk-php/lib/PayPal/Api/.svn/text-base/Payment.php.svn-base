<?php
namespace PayPal\Api;

use PayPal\Common\PPModel;
use PayPal\Rest\IResource;
use PayPal\Rest\Call;
use PayPal\Rest\ApiContext;
use PayPal\Api\Payment;
use PayPal\Api\PaymentHistory;
use PayPal\Transport\PPRestCall;

class Payment extends PPModel implements IResource {

	private static $credential;

	/**
	 *
	 * @deprecated. Pass ApiContext to create/get methods instead
	 */
	public static function setCredential($credential) {
		self::$credential = $credential;
	}

	/**
	 * Identifier of the payment resource created.
	 * @param string $id
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	/**
	 * Identifier of the payment resource created.
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}


	/**
	 * Time the resource was created.
	 * @param string $create_time
	 */
	public function setCreateTime($create_time) {
		$this->create_time = $create_time;
		return $this;
	}

	/**
	 * Time the resource was created.
	 * @return string
	 */
	public function getCreateTime() {
		return $this->create_time;
	}

	/**
	 * Time the resource was created.
	 * @param string $create_time
	 * @deprecated. Instead use setCreateTime
	 */
	public function setCreate_time($create_time) {
		$this->create_time = $create_time;
		return $this;
	}
	/**
	 * Time the resource was created.
	 * @return string
	 * @deprecated. Instead use getCreateTime
	 */
	public function getCreate_time() {
		return $this->create_time;
	}

	/**
	 * Time the resource was last updated.
	 * @param string $update_time
	 */
	public function setUpdateTime($update_time) {
		$this->update_time = $update_time;
		return $this;
	}

	/**
	 * Time the resource was last updated.
	 * @return string
	 */
	public function getUpdateTime() {
		return $this->update_time;
	}

	/**
	 * Time the resource was last updated.
	 * @param string $update_time
	 * @deprecated. Instead use setUpdateTime
	 */
	public function setUpdate_time($update_time) {
		$this->update_time = $update_time;
		return $this;
	}
	/**
	 * Time the resource was last updated.
	 * @return string
	 * @deprecated. Instead use getUpdateTime
	 */
	public function getUpdate_time() {
		return $this->update_time;
	}

	/**
	 * Intent of the payment - Sale or Authorization or Order.
	 * @param string $intent
	 */
	public function setIntent($intent) {
		$this->intent = $intent;
		return $this;
	}

	/**
	 * Intent of the payment - Sale or Authorization or Order.
	 * @return string
	 */
	public function getIntent() {
		return $this->intent;
	}


	/**
	 * Source of the funds for this payment represented by a PayPal account or a direct credit card.
	 * @param PayPal\Api\Payer $payer
	 */
	public function setPayer($payer) {
		$this->payer = $payer;
		return $this;
	}

	/**
	 * Source of the funds for this payment represented by a PayPal account or a direct credit card.
	 * @return PayPal\Api\Payer
	 */
	public function getPayer() {
		return $this->payer;
	}


	/**
	 * A payment can have more than one transaction, with each transaction establishing a contract between the payer and a payee
	 * @array
	 * @param PayPal\Api\Transaction $transactions
	 */
	public function setTransactions($transactions) {
		$this->transactions = $transactions;
		return $this;
	}

	/**
	 * A payment can have more than one transaction, with each transaction establishing a contract between the payer and a payee
	 * @return PayPal\Api\Transaction
	 */
	public function getTransactions() {
		return $this->transactions;
	}


	/**
	 * state of the payment
	 * @param string $state
	 */
	public function setState($state) {
		$this->state = $state;
		return $this;
	}

	/**
	 * state of the payment
	 * @return string
	 */
	public function getState() {
		return $this->state;
	}


	/**
	 * Redirect urls required only when using payment_method as PayPal - the only settings supported are return and cancel urls.
	 * @param PayPal\Api\RedirectUrls $redirect_urls
	 */
	public function setRedirectUrls($redirect_urls) {
		$this->redirect_urls = $redirect_urls;
		return $this;
	}

	/**
	 * Redirect urls required only when using payment_method as PayPal - the only settings supported are return and cancel urls.
	 * @return PayPal\Api\RedirectUrls
	 */
	public function getRedirectUrls() {
		return $this->redirect_urls;
	}

	/**
	 * Redirect urls required only when using payment_method as PayPal - the only settings supported are return and cancel urls.
	 * @param PayPal\Api\RedirectUrls $redirect_urls
	 * @deprecated. Instead use setRedirectUrls
	 */
	public function setRedirect_urls($redirect_urls) {
		$this->redirect_urls = $redirect_urls;
		return $this;
	}
	/**
	 * Redirect urls required only when using payment_method as PayPal - the only settings supported are return and cancel urls.
	 * @return PayPal\Api\RedirectUrls
	 * @deprecated. Instead use getRedirectUrls
	 */
	public function getRedirect_urls() {
		return $this->redirect_urls;
	}

	/**
	 * 
	 * @array
	 * @param PayPal\Api\Links $links
	 */
	public function setLinks($links) {
		$this->links = $links;
		return $this;
	}

	/**
	 * 
	 * @return PayPal\Api\Links
	 */
	public function getLinks() {
		return $this->links;
	}



	public function create($apiContext = null) {
		$payLoad = $this->toJSON();
		if ($apiContext == null) {
			$apiContext = new ApiContext(self::$credential);
		}
		$call = new PPRestCall($apiContext);
		$json = $call->execute(array('PayPal\Rest\RestHandler'), "/v1/payments/payment", "POST", $payLoad);
		$this->fromJson($json);
 		return $this;
	}

	public static function get($paymentId, $apiContext = null) {
		if (($paymentId == null) || (strlen($paymentId) <= 0)) {
			throw new \InvalidArgumentException("paymentId cannot be null or empty");
		}
		$payLoad = "";
		if ($apiContext == null) {
			$apiContext = new ApiContext(self::$credential);
		}
		$call = new PPRestCall($apiContext);
		$json = $call->execute(array('PayPal\Rest\RestHandler'), "/v1/payments/payment/$paymentId", "GET", $payLoad);
		$ret = new Payment();
		$ret->fromJson($json);
		return $ret;
	}

	public function execute($paymentExecution, $apiContext = null) {
		if ($this->getId() == null) {
			throw new \InvalidArgumentException("Id cannot be null");
		}
		if (($paymentExecution == null)) {
			throw new \InvalidArgumentException("paymentExecution cannot be null or empty");
		}
		$payLoad = $paymentExecution->toJSON();
		if ($apiContext == null) {
			$apiContext = new ApiContext(self::$credential);
		}
		$call = new PPRestCall($apiContext);
		$json = $call->execute(array('PayPal\Rest\RestHandler'), "/v1/payments/payment/{$this->getId()}/execute", "POST", $payLoad);
		$ret = new Payment();
		$ret->fromJson($json);
		return $ret;
	}

	public static function all($params, $apiContext = null) {
		if (($params == null)) {
			throw new \InvalidArgumentException("params cannot be null or empty");
		}
		$payLoad = "";
		$allowedParams = array('count' => 1, 'start_id' => 1, 'start_index' => 1, 'start_time' => 1, 'end_time' => 1, 'payee_id' => 1, 'sort_by' => 1, 'sort_order' => 1, );
		if ($apiContext == null) {
			$apiContext = new ApiContext(self::$credential);
		}
		$call = new PPRestCall($apiContext);
		$json = $call->execute(array('PayPal\Rest\RestHandler'), "/v1/payments/payment?" . http_build_query(array_intersect_key($params, $allowedParams)), "GET", $payLoad);
		$ret = new PaymentHistory();
		$ret->fromJson($json);
		return $ret;
	}
}
