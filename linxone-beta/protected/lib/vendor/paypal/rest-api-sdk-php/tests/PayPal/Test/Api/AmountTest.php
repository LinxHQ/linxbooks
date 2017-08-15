<?php

namespace PayPal\Test\Api;

use PayPal\Api\Amount;
use PayPal\Test\Constants;

class AmountTest extends \PHPUnit_Framework_TestCase {

	private $amounts;

	public static $currency = "USD";
	public static $total = "1.12";	

	public static function createAmount() {
		$amount = new Amount();
		$amount->setCurrency(self::$currency);
		$amount->setTotal(self::$total);
		
		return $amount;
	}
	
	public function setup() {
		$this->amounts['partial'] = self::createAmount();
		
		$amount = self::createAmount();
		$amount->setDetails(DetailsTest::createAmountDetails());
		$this->amounts['full'] = $amount;
	}

	public function testGetterSetter() {
		$this->assertEquals(self::$currency, $this->amounts['partial']->getCurrency());
		$this->assertEquals(self::$total, $this->amounts['partial']->getTotal());
		$this->assertEquals(DetailsTest::$fee, $this->amounts['full']->getDetails()->getFee());
	}
	
	public function testSerializeDeserialize() {
		$a1 = $this->amounts['partial'];
		
		$a2 = new Amount();
		$a2->fromJson($a1->toJson());
		
		$this->assertEquals($a1, $a2);
	}
}