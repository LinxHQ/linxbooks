<?php
namespace PayPal\Test\Api;

use PayPal\Api\RelatedResources;
use PayPal\Test\Constants;

class RelatedResourcesTest extends \PHPUnit_Framework_TestCase {

	private $RelatedResources;

	public static function createRelatedResources() {
		$relatedResources = new RelatedResources();
		$relatedResources->setAuthorization(AuthorizationTest::createAuthorization());
		$relatedResources->setCapture(CaptureTest::createCapture());
		return $relatedResources;
	}
	
	public function setup() {
		$this->relatedResources = self::createRelatedResources();
	}

	public function testGetterSetter() {
		$this->assertEquals(AuthorizationTest::$create_time, $this->relatedResources->getAuthorization()->getCreateTime());
		$this->assertEquals(CaptureTest::$create_time, $this->relatedResources->getCapture()->getCreateTime());
	}
	
	public function testSerializeDeserialize() {
		$s1 = $this->relatedResources;
		
		$s2 = new RelatedResources();
		$s2->fromJson($s1->toJson());
		
		$this->assertEquals($s1, $s2);
	}
}