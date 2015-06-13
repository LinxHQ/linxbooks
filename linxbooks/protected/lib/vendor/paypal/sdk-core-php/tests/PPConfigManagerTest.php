<?php
use PayPal\Core\PPConfigManager;
/**
 * Test class for PPConfigManager.
 *
 */
class PPConfigManagerTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var PPConfigManager
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = PPConfigManager::getInstance();
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
	public function testGetInstance()
	{
		$instance = $this->object->getInstance();
		$this->assertTrue($instance instanceof PPConfigManager);
	}

	/**
	 * @test
	 */
	public function testGetIniPrefix()
	{
		$ret = $this->object->getIniPrefix();
		$this->assertContains('acct1', $ret);
		$this->assertEquals(sizeof($ret), 2);
		
		$ret = $this->object->getIniPrefix('jb-us-seller_api1.paypal.com');
		$this->assertEquals('acct1', $ret);
	}
}
?>
