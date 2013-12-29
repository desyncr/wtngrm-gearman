<?php
namespace Desyncr\Wtngrm\Gearman\Factory;

/**
 * Generated by PHPUnit_SkeletonGenerator
 */
class GearmanServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GearmanServiceFactory
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
       $servers = array('servers' =>
                        array('client' =>
                            array(
                               array('host' => '127.0.0.1', 1111)
                           )
                       )
                   );
       $gearman = array(
           'gearman-adapter' => $servers
       );
       $this->config = array('wtngrm' => $gearman);

       $this->object = new GearmanServiceFactory;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Desyncr\Wtngrm\Gearman\Factory\GearmanServiceFactory::createService
     */
    public function testCreateService()
    {

        $sm = $this->getMockBuilder('Zend\ServiceManager\ServiceLocatorInterface', array('get', 'has'))
                    ->getMock();

        $sm->expects($this->any())
            ->method('get')
            ->will($this->returnValue($this->config));

        $obj = $this->object->createService($sm);

        $this->
            assertInstanceOf('Desyncr\Wtngrm\Gearman\Service\GearmanService', $obj);

    }

    /**
     * @covers Desyncr\Wtngrm\Gearman\Factory\GearmanServiceFactory::createService
     */
    public function testCreateServiceOptions()
    {

        $sm = $this->getMockBuilder('Zend\ServiceManager\ServiceLocatorInterface', array('get', 'has'))
                    ->getMock();

        $sm->expects($this->any())
            ->method('get')
            ->will($this->returnValue($this->config));

        $obj = $this->object->createService($sm);

        $this->assertEquals($this->config['wtngrm']['gearman-adapter']['servers'], $obj->servers);

    }
}
