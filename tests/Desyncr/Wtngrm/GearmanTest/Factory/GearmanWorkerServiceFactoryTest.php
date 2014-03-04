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

use Desyncr\Wtngrm\Gearman\Factory\GearmanWorkerServiceFactory;
use Desyncr\Wtngrm\Gearman\Options\GearmanWorkerOptions;

/**
 * Class GearmanWorkerServiceFactoryTest
 *
 * @category General
 * @package  Desyncr\Wtngrm\GearmanTest\Factory
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  https://www.gnu.org/licenses/gpl.html GPL-3.0+
 * @link     https://github.com/desyncr
 */
class GearmanWorkerServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Desyncr\Wtngrm\Gearman\Factory\GearmanWorkerServiceFactory
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $servers = array(
           'servers' =>
                array(
                    'workers' =>
                        array(
                            array(
                                'host' => '127.0.0.1', 'port' => 1111
                            )
                        )
                )
           );

        $this->config = $servers;
        $this->object = new GearmanWorkerServiceFactory();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Desyncr\Wtngrm\Gearman\Factory\GearmanWorkerServiceFactory::createService
     */
    public function testCreateService()
    {

        $sm = $this->getMockBuilder(
            'Zend\ServiceManager\ServiceLocatorInterface',
            array('get', 'has')
        )->getMock();

        $gearmanMock = $this->getMockBuilder(
            'GearmanWorker',
            'addServer'
        )->getMock();

        $gearmanMock->expects($this->any())
            ->method('addServer')
            ->will($this->returnValue(true));

        $map = array(
            array('Config' , $this->config),
            array('Desyncr\Wtngrm\Gearman\Worker\GearmanWorker', $gearmanMock),
            array('Desyncr\Wtngrm\Gearman\Options\GearmanWorkerOptions', new GearmanWorkerOptions($this->config))
        );

        $sm->expects($this->any())
            ->method('get')
            ->will($this->returnValueMap($map));

        $obj = $this->object->createService($sm);

        $this->assertInstanceOf(
            'Desyncr\Wtngrm\Gearman\Service\GearmanWorkerService',
            $obj
        );
    }

    /**
     * @covers Desyncr\Wtngrm\Gearman\Factory\GearmanWorkerServiceFactory::createService
     */
    public function testCreateServiceOptions()
    {

        $sm = $this->getMockBuilder(
            'Zend\ServiceManager\ServiceLocatorInterface',
            array('get', 'has')
        )->getMock();

        $gearmanMock = $this->getMockBuilder(
            'GearmanWorker',
            array('addServer')
        )->getMock();
        $gearmanMock->expects($this->any())
            ->method('addServer')
            ->will($this->returnValue(true));

        $map = array(
            array('Config', $this->config),
            array('Desyncr\Wtngrm\Gearman\Worker\GearmanWorker', $gearmanMock),
            array('Desyncr\Wtngrm\Gearman\Options\GearmanWorkerOptions', new GearmanWorkerOptions($this->config))
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
