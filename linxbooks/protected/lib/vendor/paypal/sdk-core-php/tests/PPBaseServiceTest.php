<?php
use PayPal\Core\PPBaseService;
/**
 * Test class for PPBaseService.
 *
 */
class PPBaseServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PPBaseService
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new PPBaseService('serviceName', 'serviceBinding', null);
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
    public function testGetServiceName()
    {
        $this->assertEquals('serviceName',$this->object->getServiceName() );
    }


}
?>
