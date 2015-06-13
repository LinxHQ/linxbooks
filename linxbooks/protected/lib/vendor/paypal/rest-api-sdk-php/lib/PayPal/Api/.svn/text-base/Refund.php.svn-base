<?php
namespace PayPal\Api;

use PayPal\Common\PPModel;
use PayPal\Rest\IResource;
use PayPal\Rest\Call;
use PayPal\Rest\ApiContext;
use PayPal\Api\Refund;
use PayPal\Transport\PPRestCall;

class Refund extends PPModel implements IResource {

	private static $credential;

	/**
	 *
	 * @deprecated. Pass ApiContext to create/get methods instead
	 */
	public static function setCredential($credential) {
		self::$credential = $credential;
	}

	/**
	 * Identifier of the refund transaction.
	 * @param string $id
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	/**
	 * Identifier of the refund transaction.
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
	 * Details including both refunded amount (to Payer) and refunded fee (to Payee).If amount is not specified, it's assumed to be full refund.
	 * @param PayPal\Api\Amount $amount
	 */
	public function setAmount($amount) {
		$this->amount = $amount;
		return $this;
	}

	/**
	 * Details including both refunded amount (to Payer) and refunded fee (to Payee).If amount is not specified, it's assumed to be full refund.
	 * @return PayPal\Api\Amount
	 */
	public function getAmount() {
		return $this->amount;
	}


	/**
	 * State of the refund transaction.
	 * @param string $state
	 */
	public function setState($state) {
		$this->state = $state;
		return $this;
	}

	/**
	 * State of the refund transaction.
	 * @return string
	 */
	public function getState() {
		return $this->state;
	}


	/**
	 * ID of the Sale transaction being refunded. 
	 * @param string $sale_id
	 */
	public function setSaleId($sale_id) {
		$this->sale_id = $sale_id;
		return $this;
	}

	/**
	 * ID of the Sale transaction being refunded. 
	 * @return string
	 */
	public function getSaleId() {
		return $this->sale_id;
	}

	/**
	 * ID of the Sale transaction being refunded. 
	 * @param string $sale_id
	 * @deprecated. Instead use setSaleId
	 */
	public function setSale_id($sale_id) {
		$this->sale_id = $sale_id;
		return $this;
	}
	/**
	 * ID of the Sale transaction being refunded. 
	 * @return string
	 * @deprecated. Instead use getSaleId
	 */
	public function getSale_id() {
		return $this->sale_id;
	}

	/**
	 * ID of the Capture transaction being refunded. 
	 * @param string $capture_id
	 */
	public function setCaptureId($capture_id) {
		$this->capture_id = $capture_id;
		return $this;
	}

	/**
	 * ID of the Capture transaction being refunded. 
	 * @return string
	 */
	public function getCaptureId() {
		return $this->capture_id;
	}

	/**
	 * ID of the Capture transaction being refunded. 
	 * @param string $capture_id
	 * @deprecated. Instead use setCaptureId
	 */
	public function setCapture_id($capture_id) {
		$this->capture_id = $capture_id;
		return $this;
	}
	/**
	 * ID of the Capture transaction being refunded. 
	 * @return string
	 * @deprecated. Instead use getCaptureId
	 */
	public function getCapture_id() {
		return $this->capture_id;
	}

	/**
	 * ID of the Payment resource that this transaction is based on.
	 * @param string $parent_payment
	 */
	public function setParentPayment($parent_payment) {
		$this->parent_payment = $parent_payment;
		return $this;
	}

	/**
	 * ID of the Payment resource that this transaction is based on.
	 * @return string
	 */
	public function getParentPayment() {
		return $this->parent_payment;
	}

	/**
	 * ID of the Payment resource that this transaction is based on.
	 * @param string $parent_payment
	 * @deprecated. Instead use setParentPayment
	 */
	public function setParent_payment($parent_payment) {
		$this->parent_payment = $parent_payment;
		return $this;
	}
	/**
	 * ID of the Payment resource that this transaction is based on.
	 * @return string
	 * @deprecated. Instead use getParentPayment
	 */
	public function getParent_payment() {
		return $this->parent_payment;
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



	public static function get($refundId, $apiContext = null) {
		if (($refundId == null) || (strlen($refundId) <= 0)) {
			throw new \InvalidArgumentException("refundId cannot be null or empty");
		}
		$payLoad = "";
		if ($apiContext == null) {
			$apiContext = new ApiContext(self::$credential);
		}
		$call = new PPRestCall($apiContext);
		$json = $call->execute(array('PayPal\Rest\RestHandler'), "/v1/payments/refund/$refundId", "GET", $payLoad);
		$ret = new Refund();
		$ret->fromJson($json);
		return $ret;
	}
}
