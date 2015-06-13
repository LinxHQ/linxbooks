<?php

namespace PayPal\Test\Api;

use PayPal\Api\PaymentHistory;
use PayPal\Test\Constants;

class PaymentHistoryTest extends \PHPUnit_Framework_TestCase {
	
	private $history;
	
	public static $count = "10";
	public static $nextId = "11";
	
	public static function createPaymentHistory() {
		$history = new PaymentHistory();
		$history->setCount(self::$count);
		$history->setNextId(self::$nextId);
		$history->setPayments(array(PaymentTest::createPayment()));
		return $history;
	}
	public function setup() {		
		$this->history = PaymentHistoryTest::createPaymentHistory();
	}
	
	public function testGetterSetters() {
		$this->assertEquals(self::$count, $this->history->getCount());
		$this->assertEquals(self::$nextId, $this->history->getNextId());
		
	}
	
	public function testSerializeDeserialize() {
		$history = new PaymentHistory();
		$history->fromJson($this->history->toJSON());
	
		$this->assertEquals($history, $this->history);
	}
	
}