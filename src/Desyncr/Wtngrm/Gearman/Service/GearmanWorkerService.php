<?php
/**
 * General
 *
 * PHP version 5.4
 *
 * @category General
 * @package  General
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  https://www.gnu.org/licenses/gpl.html GPL-3.0+
 * @version  GIT:<>
 * @link     https://github.com/desyncr
 */
namespace Desyncr\Wtngrm\Gearman\Service;

/**
 * Desyncr\Wtngrm\Gearman\Service
 *
 * @category General
 * @package  Desyncr\Wtngrm\Gearman\Service
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  https://www.gnu.org/licenses/gpl.html GPL-3.0+
 * @link     https://github.com/desyncr
 */
class GearmanWorkerService extends AbstractGearmanService
{
    /**
     * @var null
     */
    protected $instance = null;

    /**
     * Returns a new instance of GearmanWorkerService
     *
     * @param Object $gearman Gearman instance
     * @param Array  $options Options array
     *
     * @throws \Exception
     * @return GearmanWorkerService
     */
    public function __construct($gearman, $options)
    {
        $this->setOptions($options);
        $this->setGearmanInstance($gearman);

        $servers = $this->getServers('workers');
        if (!count($servers)) {
            throw new \Exception('Define at least a worker Gearman server.');
        }

        set_error_handler(array($this, 'errorHandler'));
        $instance = $this->getGearmanInstance();
        foreach ($servers as $server) {
            $instance->addServer($server['host'], $server['port']);
        }
        restore_error_handler();
    }

    /**
     * Adds a function to the worker
     *
     * @param String $function Function id
     * @param Mixed  $worker   A gearman worker
     * @param null   $target   Unused
     *
     * @return \Desyncr\Wtngrm\Job\BaseJob|void
     */
    public function add($function, $worker, $target = null)
    {
        set_error_handler(array($this, 'errorHandler'));
        $this->getGearmanInstance()->addFunction($function, $worker);
        restore_error_handler();
    }

    /**
     * Dispatchs a job to a worker
     *
     * @return bool
     */
    public function dispatch()
    {
        set_error_handler(array($this, 'errorHandler'));
        $res = $this->getGearmanInstance()->work();
        restore_error_handler();
        return $res;
    }
}
