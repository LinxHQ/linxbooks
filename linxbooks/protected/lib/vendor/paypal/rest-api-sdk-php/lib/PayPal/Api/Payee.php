<?php
namespace PayPal\Api;

use PayPal\Common\PPModel;

class Payee extends PPModel {
	/**
	 * Email Address associated with the Payee's PayPal Account. If the provided email address is not associated with any PayPal Account, the payee can only receiver PayPal Wallet Payments. Direct Credit Card Payments will be denied due to card compliance requirements.
	 * @param string $email
	 */
	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}

	/**
	 * Email Address associated with the Payee's PayPal Account. If the provided email address is not associated with any PayPal Account, the payee can only receiver PayPal Wallet Payments. Direct Credit Card Payments will be denied due to card compliance requirements.
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}


	/**
	 * Encrypted PayPal Account identifier for the Payee.
	 * @param string $merchant_id
	 */
	public function setMerchantId($merchant_id) {
		$this->merchant_id = $merchant_id;
		return $this;
	}

	/**
	 * Encrypted PayPal Account identifier for the Payee.
	 * @return string
	 */
	public function getMerchantId() {
		return $this->merchant_id;
	}

	/**
	 * Encrypted PayPal Account identifier for the Payee.
	 * @param string $merchant_id
	 * @deprecated. Instead use setMerchantId
	 */
	public function setMerchant_id($merchant_id) {
		$this->merchant_id = $merchant_id;
		return $this;
	}
	/**
	 * Encrypted PayPal Account identifier for the Payee.
	 * @return string
	 * @deprecated. Instead use getMerchantId
	 */
	public function getMerchant_id() {
		return $this->merchant_id;
	}

	/**
	 * Phone number (in E.123 format) associated with the Payee's PayPal Account. If the provided phont number is not associated with any PayPal Account, the payee can only receiver PayPal Wallet Payments. Direct Credit Card Payments will be denied due to card compliance requirements.
	 * @param string $phone
	 */
	public function setPhone($phone) {
		$this->phone = $phone;
		return $this;
	}

	/**
	 * Phone number (in E.123 format) associated with the Payee's PayPal Account. If the provided phont number is not associated with any PayPal Account, the payee can only receiver PayPal Wallet Payments. Direct Credit Card Payments will be denied due to card compliance requirements.
	 * @return string
	 */
	public function getPhone() {
		return $this->phone;
	}


}
