<?php
/**
 * Desyncr\Wtngrm\GearmanTest\Factory
 *
 * PHP version 5.4
 *
 * @category General
 * @package  Desyncr\Wtngrm\GearmanTest\Factory
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  https://www.gnu.org/licenses/gpl.html GPL-3.0+
 * @version  GIT:<>
 * @link     https://github.com/desyncr
 */
namespace Desyncr\Wtngrm\GearmanTest\Factory;

use Desyncr\Wtngrm\Gearman\Factory\GearmanClientServiceFactory;
use Desyncr\Wtngrm\Gearman\Options\GearmanClientOptions;

/**
 * Class GearmanClientServiceFactoryTest
 *
 * @category General
 * @package  Desyncr\Wtngrm\GearmanTest\Factory
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  https://www.gnu.org/licenses/gpl.html GPL-3.0+
 * @link     https://github.com/desyncr
 */
class GearmanClientServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Desyncr\Wtngrm\Gearman\Factory\GearmanClientServiceFactory
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
                    array('host' => '127.0.0.1', 'port' => 1111)
                )
            )
        );

        $this->config = $servers;

        $this->object = new GearmanClientServiceFactory();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Desyncr\Wtngrm\Gearman\Factory\GearmanClientServiceFactory::createService
     */
    public function testCreateService()
    {
        $sm = $this->getMockBuilder(
            'Zend\ServiceManager\ServiceLocatorInterface',
            array('get', 'has')
        )->getMock();

        $gearmanMock = $this->getMockBuilder(
            'GearmanClient',
            array('addServers')
        )->getMock();

        $gearmanMock->expects($this->any())
            ->method('addServers')
            ->will($this->returnValue(true));

        $gearmanOptions = new GearmanClientOptions($this->config);

        $map = array(
            array('Config', $this->config),
            array('Desyncr\Wtngrm\Gearman\Client\GearmanClient', $gearmanMock),
            array('Desyncr\Wtngrm\Gearman\Options\GearmanClientOptions', $gearmanOptions)
        );

        $sm->expects($this->any())
            ->method('get')
            ->will($this->returnValueMap($map));

        $obj = $this->object->createService($sm);

        $this->assertInstanceOf(
            'Desyncr\Wtngrm\Gearman\Service\GearmanClientService',
            $obj
        );

    }

    /**
     * @covers Desyncr\Wtngrm\Gearman\Factory\GearmanClientServiceFactory::createService
     */
    public function testCreateServiceOptions()
    {
        $sm = $this->getMockBuilder(
            'Zend\ServiceManager\ServiceLocatorInterface',
            array('get', 'has')
        )->getMock();

        $gearmanMock = $this->getMockBuilder(
            'GearmanClient',
            array('addServers')
        )->getMock();
        $gearmanMock->expects($this->any())
            ->method('addServer')
            ->will($this->returnValue(true));

        $map = array(
            array('Config', $this->config),
            array('Desyncr\Wtngrm\Gearman\Client\GearmanClient', $gearmanMock),
            array('Desyncr\Wtngrm\Gearman\Options\GearmanClientOptions', new GearmanClientOptions($this->config))
        );

        $sm->expects($this->any())
            ->method('get')
            ->will($this->returnValueMap($map));

        $obj = $this->object->createService($sm);

        $this->assertEquals(
            $this->config['servers'],
            $obj->getOptions()->getServers()
        );
    }
}
