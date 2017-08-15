<?php
namespace PayPal\Test\Common;
use PayPal\Common\PPArrayUtil;

class ArrayUtilTest extends \PHPUnit_Framework_TestCase {
	
	public function testIsAssocArray() {
		
		$arr = array(1, 2, 3);
		$this->assertEquals(false, PPArrayUtil::isAssocArray($arr));	
		
		$arr = array(
			'name' => 'John Doe',
			'City' => 'San Jose'
		);
		$this->assertEquals(true, PPArrayUtil::isAssocArray($arr));
		
		$arr[] = 'CA';
		$this->assertEquals(false, PPArrayUtil::isAssocArray($arr));
	}
}
