<?php
namespace PayPal\Api;

use PayPal\Common\PPModel;

class CreditCardToken extends PPModel {
	/**
	 * ID of a previously saved Credit Card resource using /vault/credit-card API.
	 * @param string $credit_card_id
	 */
	public function setCreditCardId($credit_card_id) {
		$this->credit_card_id = $credit_card_id;
		return $this;
	}

	/**
	 * ID of a previously saved Credit Card resource using /vault/credit-card API.
	 * @return string
	 */
	public function getCreditCardId() {
		return $this->credit_card_id;
	}

	/**
	 * ID of a previously saved Credit Card resource using /vault/credit-card API.
	 * @param string $credit_card_id
	 * @deprecated. Instead use setCreditCardId
	 */
	public function setCredit_card_id($credit_card_id) {
		$this->credit_card_id = $credit_card_id;
		return $this;
	}
	/**
	 * ID of a previously saved Credit Card resource using /vault/credit-card API.
	 * @return string
	 * @deprecated. Instead use getCreditCardId
	 */
	public function getCredit_card_id() {
		return $this->credit_card_id;
	}

	/**
	 * The unique identifier of the payer used when saving this credit card using /vault/credit-card API.
	 * @param string $payer_id
	 */
	public function setPayerId($payer_id) {
		$this->payer_id = $payer_id;
		return $this;
	}

	/**
	 * The unique identifier of the payer used when saving this credit card using /vault/credit-card API.
	 * @return string
	 */
	public function getPayerId() {
		return $this->payer_id;
	}

	/**
	 * The unique identifier of the payer used when saving this credit card using /vault/credit-card API.
	 * @param string $payer_id
	 * @deprecated. Instead use setPayerId
	 */
	public function setPayer_id($payer_id) {
		$this->payer_id = $payer_id;
		return $this;
	}
	/**
	 * The unique identifier of the payer used when saving this credit card using /vault/credit-card API.
	 * @return string
	 * @deprecated. Instead use getPayerId
	 */
	public function getPayer_id() {
		return $this->payer_id;
	}

	/**
	 * Last 4 digits of the card number from the saved card.
	 * @param string $last4
	 */
	public function setLast4($last4) {
		$this->last4 = $last4;
		return $this;
	}

	/**
	 * Last 4 digits of the card number from the saved card.
	 * @return string
	 */
	public function getLast4() {
		return $this->last4;
	}


	/**
	 * Type of the Card (eg. visa, mastercard, etc.) from the saved card. Please note that the values are always in lowercase and not meant to be used directly for display.
	 * @param string $type
	 */
	public function setType($type) {
		$this->type = $type;
		return $this;
	}

	/**
	 * Type of the Card (eg. visa, mastercard, etc.) from the saved card. Please note that the values are always in lowercase and not meant to be used directly for display.
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}


	/**
	 * card expiry month from the saved card with value 1 - 12
	 * @param integer $expire_month
	 */
	public function setExpireMonth($expire_month) {
		$this->expire_month = $expire_month;
		return $this;
	}

	/**
	 * card expiry month from the saved card with value 1 - 12
	 * @return integer
	 */
	public function getExpireMonth() {
		return $this->expire_month;
	}

	/**
	 * card expiry month from the saved card with value 1 - 12
	 * @param integer $expire_month
	 * @deprecated. Instead use setExpireMonth
	 */
	public function setExpire_month($expire_month) {
		$this->expire_month = $expire_month;
		return $this;
	}
	/**
	 * card expiry month from the saved card with value 1 - 12
	 * @return integer
	 * @deprecated. Instead use getExpireMonth
	 */
	public function getExpire_month() {
		return $this->expire_month;
	}

	/**
	 * 4 digit card expiry year from the saved card
	 * @param integer $expire_year
	 */
	public function setExpireYear($expire_year) {
		$this->expire_year = $expire_year;
		return $this;
	}

	/**
	 * 4 digit card expiry year from the saved card
	 * @return integer
	 */
	public function getExpireYear() {
		return $this->expire_year;
	}

	/**
	 * 4 digit card expiry year from the saved card
	 * @param integer $expire_year
	 * @deprecated. Instead use setExpireYear
	 */
	public function setExpire_year($expire_year) {
		$this->expire_year = $expire_year;
		return $this;
	}
	/**
	 * 4 digit card expiry year from the saved card
	 * @return integer
	 * @deprecated. Instead use getExpireYear
	 */
	public function getExpire_year() {
		return $this->expire_year;
	}

}
