<?php
namespace PayPal\Api;

use PayPal\Common\PPModel;

class ShippingAddress extends Address {
	/**
	 * Name of the recipient at this address.
	 * @param string $recipient_name
	 */
	public function setRecipientName($recipient_name) {
		$this->recipient_name = $recipient_name;
		return $this;
	}

	/**
	 * Name of the recipient at this address.
	 * @return string
	 */
	public function getRecipientName() {
		return $this->recipient_name;
	}

	/**
	 * Name of the recipient at this address.
	 * @param string $recipient_name
	 * @deprecated. Instead use setRecipientName
	 */
	public function setRecipient_name($recipient_name) {
		$this->recipient_name = $recipient_name;
		return $this;
	}
	/**
	 * Name of the recipient at this address.
	 * @return string
	 * @deprecated. Instead use getRecipientName
	 */
	public function getRecipient_name() {
		return $this->recipient_name;
	}

}
