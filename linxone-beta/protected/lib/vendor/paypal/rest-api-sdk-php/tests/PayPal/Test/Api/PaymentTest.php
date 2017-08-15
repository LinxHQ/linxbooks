<?php
namespace PayPal\Test\Api;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Address;
use PayPal\Api\Amount;
use PayPal\Api\CreditCard;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Transaction;
use PayPal\Test\Constants;

class PaymentTest extends \PHPUnit_Framework_TestCase {

	private $payments;	

	public static function createPayment() {
		
		$redirectUrls = new RedirectUrls();
		$redirectUrls->setReturnUrl("http://localhost/return");
		$redirectUrls->setCancelUrl("http://localhost/cancel");
		
		$payment = new Payment();
		$payment->setIntent("sale");
		$payment->setRedirectUrls($redirectUrls);
		$payment->setPayer(PayerTest::createPayer());
		$payment->setTransactions(array(TransactionTest::createTransaction()));
		
		return $payment;				
	}
	
	public static function createNewPayment() {
		$payer = new Payer();
		$payer->setPaymentMethod("credit_card");
		$payer->setFundingInstruments(array(FundingInstrumentTest::createFundingInstrument()));
		
		$transaction = new Transaction();
		$transaction->setAmount(AmountTest::createAmount());
		$transaction->setDescription("This is the payment description.");
		
		$redirectUrls = new RedirectUrls();
		$redirectUrls->setReturnUrl("http://localhost/return");
		$redirectUrls->setCancelUrl("http://localhost/cancel");
		
		$payment = new Payment();
		$payment->setIntent("sale");
		$payment->setRedirectUrls($redirectUrls);
		$payment->setPayer($payer);
		$payment->setTransactions(array($transaction));
	
		return $payment;	
	}
	
	public function setup() {		
		$this->payments['full'] = self::createPayment();
		$this->payments['new'] = self::createNewPayment();
	}
	
	public function testSerializeDeserialize() {
		$p2 = new Payment();
		$p2->fromJson($this->payments['full']->toJSON());		
		$this->assertEquals($p2, $this->payments['full']);
	}
	
	public function testOperations() {

		$p1 = $this->payments['new'];
		 
		$p1->create();		
		$this->assertNotNull($p1->getId());
		
		$p2 = Payment::get($p1->getId());
		$this->assertNotNull($p2);
		
		$paymentHistory = Payment::all(array('count' => '10'));
		$this->assertNotNull($paymentHistory);
	}
}
