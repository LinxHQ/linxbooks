<?php 
use PayPal\Auth\Openid\PPOpenIdAddress;
/**
 * Test class for PPOpenIdAddress.
 *
 */
class PPOpenIdAddressTest extends \PHPUnit_Framework_TestCase {
	
	public $addr;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp() {
		$this->addr = new PPOpenIdAddress();
		$this->addr->setCountry("US")->setLocality("San Jose")
		->setPostalCode("95112")->setRegion("CA")
		->setStreetAddress("1, North 1'st street");
	}
	
	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}
	
	/**
	 * @test
	 */
	public function testSerializationDeserialization() {				
		$addrCopy = new PPOpenIdAddress();
		$addrCopy->fromJson($this->addr->toJson());
		
		$this->assertEquals($this->addr, $addrCopy);
	}
}