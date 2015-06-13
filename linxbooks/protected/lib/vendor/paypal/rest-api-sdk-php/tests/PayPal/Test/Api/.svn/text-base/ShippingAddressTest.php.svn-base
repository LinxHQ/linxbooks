<?php
namespace PayPal\Test\Api;

use PayPal\Api\ShippingAddress;
use PayPal\Test\Constants;

class ShippingAddressTest extends \PHPUnit_Framework_TestCase {

	private $address;

	public static $line1 = "3909 Witmer Road";
	public static $line2 = "Niagara Falls";	
	public static $city = "Niagara Falls";
	public static $state = "NY";
	public static $postalCode = "14305";
	public static $countryCode = "US";
	public static $phone = "716-298-1822";
	public static $recipientName = "TestUser";

	public static function createAddress() {
		$addr = new ShippingAddress();
		$addr->setLine1(self::$line1);
		$addr->setLine2(self::$line2);
		$addr->setCity(self::$city);
		$addr->setState(self::$state);
		$addr->setPostalCode(self::$postalCode);
		$addr->setCountryCode(self::$countryCode);
		$addr->setPhone(self::$phone);
		$addr->setRecipientName(self::$recipientName);
		return $addr;
	}
	
	public function setup() {
		$this->address = self::createAddress();
	}

	public function testGetterSetter() {
		$this->assertEquals(self::$line1, $this->address->getLine1());
		$this->assertEquals(self::$line2, $this->address->getLine2());
		$this->assertEquals(self::$city, $this->address->getCity());
		$this->assertEquals(self::$state, $this->address->getState());
		$this->assertEquals(self::$postalCode, $this->address->getPostalCode());
		$this->assertEquals(self::$countryCode, $this->address->getCountryCode());
		$this->assertEquals(self::$phone, $this->address->getPhone());
		$this->assertEquals(self::$recipientName, $this->address->getRecipientName());
	}
	
	public function testSerializeDeserialize() {
		$a1 = $this->address;
		
		$a2 = new ShippingAddress();
		$a2->fromJson($a1->toJson());
		
		$this->assertEquals($a1, $a2);
	}
}