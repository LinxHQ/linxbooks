<?php 
namespace PayPal\Test\Common;
use PayPal\Common\PPModel;
use PayPal\Test\Common\ArrayClass;
use PayPal\Test\Common\SimpleClass;
use PayPal\Test\Common\NestedClass;
class ModelTest extends \PHPUnit_Framework_TestCase {
	
	public function testSimpleClassConversion() {
		$o = new SimpleClass();
		$o->setName("test");
		$o->setDescription("description");

		$this->assertEquals("test", $o->getName());
		$this->assertEquals("description", $o->getDescription());
		
		$json = $o->toJSON();		
		$this->assertEquals('{"name":"test","desc":"description"}', $json);
		
		$newO = new SimpleClass();
		$newO->fromJson($json);
		$this->assertEquals($o, $newO);
		
	}
	
	
	public function testArrayClassConversion() {
		$o = new ArrayClass();
		$o->setName("test");
		$o->setDescription("description");
		$o->setTags(array('payment', 'info', 'test'));
		
		$this->assertEquals("test", $o->getName());
		$this->assertEquals("description", $o->getDescription());
		$this->assertEquals(array('payment', 'info', 'test'), $o->getTags());
		
		$json = $o->toJSON();
		$this->assertEquals('{"name":"test","desc":"description","tags":["payment","info","test"]}', $json);
	
		$newO = new ArrayClass();
		$newO->fromJson($json);
		$this->assertEquals($o, $newO);	
	}
	
	public function testNestedClassConversion() {
		$n = new ArrayClass();
		$n->setName("test");
		$n->setDescription("description");
// 		$n->setTags(array('payment', 'info', 'test'));
		$o = new NestedClass();
		$o->setId('123');
		$o->setInfo($n);
		
		$this->assertEquals("123", $o->getId());
		$this->assertEquals("test", $o->getInfo()->getName());		
// 		$this->assertEquals(array('payment', 'info', 'test'), $o->getInfo()->getTags());
		
		$json = $o->toJSON();
// 		$this->assertEquals('{"id":"123","info":{"name":"test","desc":"description","tags":["payment","info","test"]}}', $json);
		$this->assertEquals('{"id":"123","info":{"name":"test","desc":"description"}}', $json);
		
		$newO = new NestedClass();
		$newO->fromJson($json);
		$this->assertEquals($o, $newO);
	}
}
