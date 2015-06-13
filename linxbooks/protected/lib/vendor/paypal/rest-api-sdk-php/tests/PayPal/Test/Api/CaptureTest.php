<?php
namespace PayPal\Test\Api;

use PayPal\Api\Capture;
use PayPal\Api\Refund;
use PayPal\Api\Authorization;
use PayPal\Api\Amount;
use PayPal\Test\Constants;

class CaptureTest extends \PHPUnit_Framework_TestCase {

	private $captures;

	public static $authorization_id = "AUTH-123";
	public static $create_time = "2013-02-28T00:00:00Z";
	public static $id = "C-5678";
	public static $parent_payment = "PAY-123";
	public static $state = "Created";

	public static function createCapture() {
		$capture = new Capture();
		$capture->setCreateTime(self::$create_time);
		$capture->setId(self::$id);
		$capture->setParentPayment(self::$parent_payment);
		$capture->setState(self::$state);		
		
		return $capture;
	}
	
	public function setup() {
		$this->captures['partial'] = self::createCapture();
		
		$capture = self::createCapture();
		$capture->setAmount(AmountTest::createAmount());
		$capture->setLinks(array(LinksTest::createLinks()));
		$this->captures['full'] = $capture;
	}

	public function testGetterSetter() {
		$this->assertEquals(self::$create_time, $this->captures['partial']->getCreateTime());
		$this->assertEquals(self::$id, $this->captures['partial']->getId());
		$this->assertEquals(self::$parent_payment, $this->captures['partial']->getParentPayment());
		$this->assertEquals(self::$state, $this->captures['partial']->getState());
		
		$this->assertEquals(AmountTest::$currency, $this->captures['full']->getAmount()->getCurrency());
		$links = $this->captures['full']->getLinks();
		$this->assertEquals(LinksTest::$href, $links[0]->getHref());
	}
	
	public function testSerializeDeserialize() {
		$c1 = $this->captures['partial'];
		
		$c2 = new Capture();
		$c2->fromJson($c1->toJson());
		
		$this->assertEquals($c1, $c2);
	}
	
	public function testOperations()
	{
		$authId = AuthorizationTest::authorize();
		$auth = Authorization::get($authId);
		
		$amount = new Amount();
		$amount->setCurrency("USD");
		$amount->setTotal("1.00");
		
		$captr = new Capture();
		$captr->setId($authId);
		$captr->setAmount($amount);
		
		$capt = $auth->capture($captr);
		$captureId = $capt->getId();
		$this->assertNotNull($captureId);
		
		$refund = new Refund();
		$refund->setId($captureId);
		$refund->setAmount($amount);
		
		$capture = Capture::get($captureId);
		$this->assertNotNull($capture->getId());
		
		$retund = $capture->refund($refund);
		$this->assertNotNull($retund->getId());
		
	}
}