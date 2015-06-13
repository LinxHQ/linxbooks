<?php

namespace PayPal\Test\Api;

use PayPal\Api\FundingInstrument;

use PayPal\Api\Payer;
use PayPal\Test\Constants;

class PayerTest extends \PHPUnit_Framework_TestCase {

	private $payer;

	private static $paymentMethod = "credit_card";

	public static function createPayer() {
		$payer = new Payer();
		$payer->setPaymentMethod(self::$paymentMethod);
		$payer->setPayerInfo(PayerInfoTest::createPayerInfo());
		$payer->setFundingInstruments(array(FundingInstrumentTest::createFundingInstrument()));
		
		return $payer;
	}
	
	public function setup() {
		$this->payer = self::createPayer();
	}

	public function testGetterSetter() {
		$this->assertEquals(self::$paymentMethod, $this->payer->getPaymentMethod());
		$this->assertEquals(PayerInfoTest::$email, $this->payer->getPayerInfo()->getEmail());
		
		$fi = $this->payer->getFundingInstruments();
		$this->assertEquals(CreditCardTokenTest::$creditCardId, $fi[0]->getCreditCardToken()->getCreditCardId());
	}
	
	public function testSerializeDeserialize() {
		$p1 = $this->payer;
		
		$p2 = new Payer();
		$p2->fromJson($p1->toJson());
		
		$this->assertEquals($p1, $p2);
	}
}