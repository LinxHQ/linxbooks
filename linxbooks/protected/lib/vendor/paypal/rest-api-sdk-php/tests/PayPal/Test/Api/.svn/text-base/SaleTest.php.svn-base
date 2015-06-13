<?php
namespace PayPal\Test\Api;

use PayPal\Api\Refund;
use PayPal\Api\Sale;
use PayPal\Test\Constants;
use PayPal\Test\Api\AmountTest;
use PayPal\Test\Api\PaymentTest;
use PayPal\Test\Api\LinksTest;

class SaleTest extends \PHPUnit_Framework_TestCase {

	private $sale;

	public static $captureId = "CAP-123";
	public static $createTime = "2013-02-28T00:00:00Z";
	public static $id = "R-5678";
	public static $parentPayment = "PAY-123";
	public static $state = "Created";

	public static function createSale() {
		$sale = new Sale();
		$sale->setAmount(AmountTest::createAmount());
		$sale->setCreateTime(self::$createTime);
		$sale->setId(self::$id);
		$sale->setLinks(array(LinksTest::createLinks()));
		$sale->setParentPayment(self::$parentPayment);		
		$sale->setState(self::$state);
		return $sale;
	}
	
	public function setup() {
		$this->sale = self::createSale();
	}

	public function testGetterSetter() {
		$this->assertEquals(self::$createTime, $this->sale->getCreateTime());
		$this->assertEquals(self::$id, $this->sale->getId());
		$this->assertEquals(self::$parentPayment, $this->sale->getParentPayment());
		$this->assertEquals(self::$state, $this->sale->getState());
		$this->assertEquals(AmountTest::$currency, $this->sale->getAmount()->getCurrency());
		$links = $this->sale->getLinks();
		$this->assertEquals(LinksTest::$href, $links[0]->getHref());
	}
	
	public function testSerializeDeserialize() {
		$s1 = $this->sale;
		
		$s2 = new Sale();
		$s2->fromJson($s1->toJson());
		
		$this->assertEquals($s1, $s2);
	}
	
	public function testOperations() {
		$payment = PaymentTest::createNewPayment();			
		$payment->create();
		
		$transactions = $payment->getTransactions();
		$resources = $transactions[0]->getRelatedResources();		
		$saleId = $resources[0]->getSale()->getId();
		
		$sale = Sale::get($saleId);
		$this->assertNotNull($sale);		
		
		$refund = new Refund();
		$refund->setAmount(AmountTest::createAmount());
		$sale->refund($refund);
		
		$this->setExpectedException('\InvalidArgumentException');
		$sale->refund(NULL);
	}
}