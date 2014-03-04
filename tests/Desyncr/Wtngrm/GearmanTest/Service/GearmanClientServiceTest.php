<?php
/**
 * Desyncr\Wtngrm\GearmanTest\Service
 *
 * PHP version 5.4
 *
 * @category General
 * @package  Desyncr\Wtngrm\GearmanTest\Service
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  https://www.gnu.org/licenses/gpl.html GPL-3.0+
 * @version  GIT:<>
 * @link     https://github.com/desyncr
 */
namespace Desyncr\Wtngrm\GearmanTest\Service;

use Desyncr\Wtngrm\Gearman\Options\GearmanClientOptions;
use Desyncr\Wtngrm\Gearman\Service\GearmanClientService;

/**
 * Class GearmanClientServiceTest
 *
 * @category General
 * @package  Desyncr\Wtngrm\GearmanTest\Service
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  https://www.gnu.org/licenses/gpl.html GPL-3.0+
 * @link     https://github.com/desyncr
 */
class GearmanClientServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Desyncr\Wtngrm\Gearman\Service\GearmanClientService
     */
    protected $object;

    /**
     * @var
     */
    protected $mock;

    /**
     * @var array
     */
    protected $defaults =
            array(
                'servers' =>
                    array(
                        'client' => array(
                                array('host' => '127.0.0.1', 'port' => 4730)
                            )
                        )
                    );

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->mock = $this->getMock('\GearmanClient');
        $this->mock->expects($this->any())
            ->method('addServer');

        $options = new GearmanClientOptions($this->defaults);
        $this->object = new GearmanClientService($this->mock, $options);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers Desyncr\Wtngrm\Gearman\Service\GearmanClientService::__construct
     */
    public function testConfiguration()
    {
        $configuration = array(
            'servers' => array(
                'client' => array(
                    array('host' => '127.0.0.1', 'port' => 4730),
                    array('host' => '127.0.0.2', 'port' => 4730)
                )
            )
        );

        $this->mock->expects($this->exactly(2))
            ->method('addServer');

        $options = new GearmanClientOptions($configuration);
        $this->object = new GearmanClientService($this->mock, $options);
        $this->assertEquals(
            $options,
            $this->object->getOptions()
        );
    }

    /**
     * @covers Desyncr\Wtngrm\Gearman\Service\GearmanClientService::dispatch
     */
    public function testDispatch()
    {
        $key = 'test.job';
        $job = array('id' => $key);
        $this->object->add($key, $job);

        $this->mock->expects($this->once())
            ->method('doBackground');

        $this->object->dispatch();

    }

    /**
     * @covers Desyncr\Wtngrm\Gearman\Service\GearmanClientService::dispatch
     */
    public function testDispatchMultipleJobs()
    {

        $key = 'test.job';
        $job = array(array(1), array(2), array(3), array(4), array(5));

        for ($i = 0 ; $i <= 4 ; $i++) {
            $this->object->add($key . $i, $job[$i]);
        }

        $this->mock
            ->expects($this->exactly(5))
            ->method('doBackground');

        $this->object->dispatch();
    }
}
