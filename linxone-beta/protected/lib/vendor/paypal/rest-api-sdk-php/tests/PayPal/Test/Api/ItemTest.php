<?php
namespace PayPal\Test\Api;

use PayPal\Api\Item;
use PayPal\Test\Constants;

class ItemTest extends \PHPUnit_Framework_TestCase {
	
	private $item;
	
	public static $name = "item name";
	public static $price = "1.12";
	public static $quantity = "10";
	public static $sku = "AXVTY123";
	public static $currency = "USD";
	
	public static function createItem() {
		$item = new Item();
		$item->setName(self::$name);
		$item->setPrice(self::$price);
		$item->setQuantity(self::$quantity);
		$item->setSku(self::$sku);
		$item->setCurrency(self::$currency);
		
		return $item;
	}
	public function setup() {		
		$this->item = ItemTest::createItem();
	}
	
	public function testGetterSetters() {
		$this->assertEquals(self::$name, $this->item->getName());
		$this->assertEquals(self::$price, $this->item->getPrice());
		$this->assertEquals(self::$sku, $this->item->getSku());
		$this->assertEquals(self::$quantity, $this->item->getQuantity());
		$this->assertEquals(self::$currency, $this->item->getCurrency());
	}
	
	public function testSerializeDeserialize() {
		$item = new Item();
		$item->fromJson($this->item->toJSON());
	
		$this->assertEquals($item, $this->item);
	}
	
}