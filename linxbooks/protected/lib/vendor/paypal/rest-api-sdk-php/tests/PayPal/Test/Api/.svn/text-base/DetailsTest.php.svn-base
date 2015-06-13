<?php
namespace PayPal\Test\Api;

use PayPal\Api\Details;
use PayPal\Test\Constants;

class DetailsTest extends \PHPUnit_Framework_TestCase {

	private $amountDetails;

	public static $subtotal = "2.00";
	public static $tax = "1.12";
	public static $shipping = "3.15";
	public static $fee = "4.99";

	public static function createAmountDetails() {
		$amountDetails = new Details();
		$amountDetails->setSubtotal(self::$subtotal);
		$amountDetails->setTax(self::$tax);
		$amountDetails->setShipping(self::$shipping);
		$amountDetails->setFee(self::$fee);
		
		return $amountDetails;
	}

	public function setup() {
		$this->amountDetails = self::createAmountDetails();
	}
	
	public function testGetterSetters() {
		$this->assertEquals(self::$subtotal, $this->amountDetails->getSubtotal());
		$this->assertEquals(self::$tax, $this->amountDetails->getTax());
		$this->assertEquals(self::$shipping, $this->amountDetails->getShipping());
		$this->assertEquals(self::$fee, $this->amountDetails->getFee());		
	}
	
	public function testSerializeDeserialize() {
		$a1 = $this->amountDetails;
		
		$a2 = new Details();
		$a2->fromJson($a1->toJson());
		
		$this->assertEquals($a1, $a2);
	}
}