<?php
namespace PayPal\Api;

use PayPal\Common\PPModel;
use PayPal\Rest\IResource;
use PayPal\Rest\Call;
use PayPal\Rest\ApiContext;
use PayPal\Api\Sale;
use PayPal\Api\Refund;
use PayPal\Transport\PPRestCall;

class Sale extends PPModel implements IResource {

	private static $credential;

	/**
	 *
	 * @deprecated. Pass ApiContext to create/get methods instead
	 */
	public static function setCredential($credential) {
		self::$credential = $credential;
	}

	/**
	 * Identifier of the authorization transaction.
	 * @param string $id
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	/**
	 * Identifier of the authorization transaction.
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
	 * Amount being collected.
	 * @param PayPal\Api\Amount $amount
	 */
	public function setAmount($amount) {
		$this->amount = $amount;
		return $this;
	}

	/**
	 * Amount being collected.
	 * @return PayPal\Api\Amount
	 */
	public function getAmount() {
		return $this->amount;
	}


	/**
	 * State of the sale transaction.
	 * @param string $state
	 */
	public function setState($state) {
		$this->state = $state;
		return $this;
	}

	/**
	 * State of the sale transaction.
	 * @return string
	 */
	public function getState() {
		return $this->state;
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



	public static function get($saleId, $apiContext = null) {
		if (($saleId == null) || (strlen($saleId) <= 0)) {
			throw new \InvalidArgumentException("saleId cannot be null or empty");
		}
		$payLoad = "";
		if ($apiContext == null) {
			$apiContext = new ApiContext(self::$credential);
		}
		$call = new PPRestCall($apiContext);
		$json = $call->execute(array('PayPal\Rest\RestHandler'), "/v1/payments/sale/$saleId", "GET", $payLoad);
		$ret = new Sale();
		$ret->fromJson($json);
		return $ret;
	}

	public function refund($refund, $apiContext = null) {
		if ($this->getId() == null) {
			throw new \InvalidArgumentException("Id cannot be null");
		}
		if (($refund == null)) {
			throw new \InvalidArgumentException("refund cannot be null or empty");
		}
		$payLoad = $refund->toJSON();
		if ($apiContext == null) {
			$apiContext = new ApiContext(self::$credential);
		}
		$call = new PPRestCall($apiContext);
		$json = $call->execute(array('PayPal\Rest\RestHandler'), "/v1/payments/sale/{$this->getId()}/refund", "POST", $payLoad);
		$ret = new Refund();
		$ret->fromJson($json);
		return $ret;
	}
}
