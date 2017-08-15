<?php
namespace PayPal\Test\Api;

use PayPal\Api\Refund;
use PayPal\Test\Constants;

class RefundTest extends \PHPUnit_Framework_TestCase {

	private $refund;

	public static $captureId = "CAP-123";
	public static $createTime = "2013-02-28T00:00:00Z";
	public static $id = "R-5678";
	public static $parentPayment = "PAY-123";

	public static function createRefund() {
		$refund = new Refund();
        $refund->setCreateTime(self::$createTime);
		$refund->setAmount(AmountTest::createAmount());
		$refund->setCaptureId(self::$captureId);
		$refund->setId(self::$id);
		$refund->setLinks(array(LinksTest::createLinks()));
		$refund->setParentPayment(self::$parentPayment);		
		
		return $refund;
	}
	
	public function setup() {
		$this->refund = self::createRefund();
	}

	public function testGetterSetter() {
		$this->assertEquals(self::$captureId, $this->refund->getCaptureId());
		$this->assertEquals(self::$createTime, $this->refund->getCreateTime());
		$this->assertEquals(self::$id, $this->refund->getId());
		$this->assertEquals(self::$parentPayment, $this->refund->getParentPayment());		
		$this->assertEquals(AmountTest::$currency, $this->refund->getAmount()->getCurrency());
		$links = $this->refund->getLinks();
		$this->assertEquals(LinksTest::$href, $links[0]->getHref());
	}
	
	public function testSerializeDeserialize() {
		$r1 = $this->refund;
		
		$r2 = new Refund();
		$r2->fromJson($r1->toJson());
		
		$this->assertEquals($r1, $r2);
	}
	
	public function testOperations() {
	
	}
}