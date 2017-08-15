<?php
namespace PayPal\Test\Api;

use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Test\Constants;

class ItemListTest extends \PHPUnit_Framework_TestCase {
	
	private $items = array();
	
	private static $name = "item name";
	private static $price = "1.12";
	private static $quantity = "10";
	private static $sku = "AXVTY123";
	private static $currency = "USD";
	
	public static function createItemList() {
		
		$item = ItemTest::createItem();
		
		$itemList = new ItemList();
		$itemList->setItems(array($item));
		$itemList->setShippingAddress(ShippingAddressTest::createAddress());
		
		return $itemList;
	}
	
	public function setup() {		
		$this->items = self::createItemList();
	}
	
	public function testGetterSetters() {
		$items = $this->items->getItems();		
		$this->assertEquals(ItemTest::createItem(), $items[0]);
		$this->assertEquals(ShippingAddressTest::createAddress(), $this->items->getShippingAddress());
	}
	
	public function testSerializeDeserialize() {
		$itemList = new ItemList();
		$itemList->fromJson($this->items->toJSON());
	
		$this->assertEquals($itemList, $this->items);
	}
	
}