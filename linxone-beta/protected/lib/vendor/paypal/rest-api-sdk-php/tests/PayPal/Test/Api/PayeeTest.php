<?php

namespace PayPal\Test\Api;

use PayPal\Api\Payee;
use PayPal\Test\Constants;

class PayeeTest extends \PHPUnit_Framework_TestCase {

	private $payee;

	public static $email = "test@paypal.com";
	public static $merchant_id = "1XY12121";
	public static $phone = "+14081234566";
	

	public static function createPayee() {
		$payee = new Payee();
		$payee->setEmail(self::$email);
		$payee->setMerchantId(self::$merchant_id);
		$payee->setPhone(self::$phone);		
		
		return $payee;
	}
	
	public function setup() {
		$this->payee = self::createPayee();
	}

	public function testGetterSetter() {
		$this->assertEquals(self::$email, $this->payee->getEmail());
		$this->assertEquals(self::$merchant_id, $this->payee->getMerchantId());
		$this->assertEquals(self::$phone, $this->payee->getPhone());
	}
	
	public function testSerializeDeserialize() {
		$p1 = $this->payee;
		
		$p2 = new Payee();
		$p2->fromJson($p1->toJson());
		
		$this->assertEquals($p1, $p2);
	}
}