<?php
namespace PayPal\Api;

use PayPal\Common\PPModel;

class Transactions extends PPModel {
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


}
