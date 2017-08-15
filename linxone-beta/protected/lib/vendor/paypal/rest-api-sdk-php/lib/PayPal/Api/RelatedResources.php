<?php
namespace PayPal\Api;

use PayPal\Common\PPModel;

class RelatedResources extends PPModel {
	/**
	 * A sale transaction
	 * @param PayPal\Api\Sale $sale
	 */
	public function setSale($sale) {
		$this->sale = $sale;
		return $this;
	}

	/**
	 * A sale transaction
	 * @return PayPal\Api\Sale
	 */
	public function getSale() {
		return $this->sale;
	}


	/**
	 * An authorization transaction
	 * @param PayPal\Api\Authorization $authorization
	 */
	public function setAuthorization($authorization) {
		$this->authorization = $authorization;
		return $this;
	}

	/**
	 * An authorization transaction
	 * @return PayPal\Api\Authorization
	 */
	public function getAuthorization() {
		return $this->authorization;
	}


	/**
	 * A capture transaction
	 * @param PayPal\Api\Capture $capture
	 */
	public function setCapture($capture) {
		$this->capture = $capture;
		return $this;
	}

	/**
	 * A capture transaction
	 * @return PayPal\Api\Capture
	 */
	public function getCapture() {
		return $this->capture;
	}


	/**
	 * A refund transaction
	 * @param PayPal\Api\Refund $refund
	 */
	public function setRefund($refund) {
		$this->refund = $refund;
		return $this;
	}

	/**
	 * A refund transaction
	 * @return PayPal\Api\Refund
	 */
	public function getRefund() {
		return $this->refund;
	}


}
