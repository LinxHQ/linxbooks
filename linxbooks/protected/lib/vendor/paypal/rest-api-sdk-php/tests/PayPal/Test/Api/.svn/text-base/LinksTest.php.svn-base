<?php

namespace PayPal\Test\Api;

use PayPal\Api\Links;
use PayPal\Test\Constants;

class LinksTest extends \PHPUnit_Framework_TestCase {

	private $links;

	public static $href = "USD";
	public static $rel = "1.12";
	public static $method = "1.12";
	
	public static function createLinks() {
		$links = new Links();
		$links->setHref(self::$href);
		$links->setRel(self::$rel);
		$links->setMethod(self::$method);
		
		return $links;
	}
	
	public function setup() {
		$this->links = self::createLinks();
	}
	
	public function testGetterSetters() {
		$this->assertEquals(self::$href, $this->links->getHref());
		$this->assertEquals(self::$rel, $this->links->getRel());
		$this->assertEquals(self::$method, $this->links->getMethod());
	}
	
	public function testSerializeDeserialize() {
		$link2 = new Links();
		$link2->fromJson($this->links->toJSON());
		$this->assertEquals($this->links, $link2);
	}
}