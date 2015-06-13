<?php
namespace PayPal\Test\Api;

use PayPal\Api\Amount;
use PayPal\Api\Authorization;
use PayPal\Api\Links;
use PayPal\Test\Constants;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Address;

use PayPal\Api\Capture;
use PayPal\Api\CreditCard;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Transaction;
use PayPal\Exception\PPConnectionException;

class AuthorizationTest extends \PHPUnit_Framework_TestCase {
	private $authorizations = array();
	public static $create_time = "2013-02-28T00:00:00Z";
	public static $id = "AUTH-123";
	public static $state = "Created";
	public static $parent_payment = "PAY-12345";
	public static $currency = "USD";
	public static $total = "1.12";
	public static $href = "USD";
	public static $rel = "1.12";
	public static $method = "1.12";
	
	public static function createAuthorization() {			
		$authorization = new Authorization();
		$authorization->setCreateTime(self::$create_time);
		$authorization->setId(self::$id);
		$authorization->setState(self::$state);
		
		$authorization->setAmount(AmountTest::createAmount());
		$authorization->setLinks(array(LinksTest::createLinks()));	
		
		return $authorization;
	}
	
	public static function authorize()
	{
		$addr = new Address();
		$addr->setLine1("3909 Witmer Road");
		$addr->setLine2("Niagara Falls");
		$addr->setCity("Niagara Falls");
		$addr->setState("NY");
		$addr->setPostal_code("14305");
		$addr->setCountry_code("US");
		$addr->setPhone("716-298-1822");
		
		$card = new CreditCard();
		$card->setType("visa");
		$card->setNumber("4417119669820331");
		$card->setExpire_month("11");
		$card->setExpire_year("2019");
		$card->setCvv2("012");
		$card->setFirst_name("Joe");
		$card->setLast_name("Shopper");
		$card->setBilling_address($addr);
		
		$fi = new FundingInstrument();
		$fi->setCredit_card($card);
		
		$payer = new Payer();
		$payer->setPayment_method("credit_card");
		$payer->setFunding_instruments(array($fi));
		
		$amount = new Amount();
		$amount->setCurrency("USD");
		$amount->setTotal("1.00");
		
		$transaction = new Transaction();
		$transaction->setAmount($amount);
		$transaction->setDescription("This is the payment description.");
		
		$payment = new Payment();
		$payment->setIntent("authorize");
		$payment->setPayer($payer);
		$payment->setTransactions(array($transaction));
		
		$paymnt = $payment->create();
		$resArray = $paymnt->toArray();
		
		return $authId = $resArray['transactions'][0]['related_resources'][0]['authorization']['id'];
		
	}
	public function setup() {
		$authorization = new Authorization();
		$authorization->setCreateTime(self::$create_time);
		$authorization->setId(self::$id);
		$authorization->setState(self::$state);
		$authorization->setParentPayment(self::$parent_payment);
		$this->authorizations['partial'] = $authorization;
		$this->authorizations['full'] = self::createAuthorization();
		
	}

	public function testGetterSetter() {		
		$authorization = $this->authorizations['partial'];
		$this->assertEquals(self::$create_time, $authorization->getCreateTime());
		$this->assertEquals(self::$id, $authorization->getId());
		$this->assertEquals(self::$state, $authorization->getState());
		$this->assertEquals(self::$parent_payment, $authorization->getParentPayment());
		
		$authorization = $this->authorizations['full'];
		$this->assertEquals(AmountTest::$currency, $authorization->getAmount()->getCurrency());
		$this->assertEquals(1, count($authorization->getLinks()));
	}
	
	public function testSerializeDeserialize() {
		$a1 = $this->authorizations['partial'];
		$a2 = new Authorization();
		$a2->fromJson($a1->toJson());
		$this->assertEquals($a1, $a2);
	}
	public function testOperations() {
		$authId = self::authorize();
		$auth = Authorization::get($authId);
		$this->assertNotNull($auth->getId());
		
		$amount = new Amount();
		$amount->setCurrency("USD");
		$amount->setTotal("1.00");
		
		$captur = new Capture();
		$captur->setId($authId);
		$captur->setAmount($amount);	
		
		$capt = $auth->capture($captur);
		$this->assertNotNull( $capt->getId());
		
		$authId = self::authorize();
		$auth = Authorization::get($authId);
		$void = $auth->void();
		$this->assertNotNull($void->getId());

	}
	
	public function testReauthorize(){
		$authorization = Authorization::get('7GH53639GA425732B');
	
		$amount = new Amount();
		$amount->setCurrency("USD");
		$amount->setTotal("1.00");
		
		$authorization->setAmount($amount);
		try{
			$reauthorization = $authorization->reauthorize();
		}catch (PPConnectionException $ex){
			$this->assertEquals(strpos($ex->getMessage(),"500"), false);
		}
	}
}