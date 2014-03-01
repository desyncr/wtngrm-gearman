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

use Desyncr\Wtngrm\Job\JobInterface;

/**
 * Desyncr\Wtngrm\Gearman\Service
 *
 * @category General
 * @package  Desyncr\Wtngrm\Gearman\Service
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  https://www.gnu.org/licenses/gpl.html GPL-3.0+
 * @link     https://github.com/desyncr
 */
class GearmanService extends AbstractGearmanService
{
    /**
     * Returns a GearmanService instance
     *
     * @param Object $gearman Gearman Service instance
     * @param Array  $options Options array
     *
     * @throws \Exception
     */
    public function __construct($gearman, $options)
    {
        $this->setOptions($options);
        $this->setGearmanInstance($gearman);

        $servers = $this->getServers('client');
        if (!count($servers)) {
            throw new \Exception('Define at least a client Gearman server.');
        }

        set_error_handler(array($this, 'errorHandler'));
        $instance = $this->getGearmanInstance();

        array_map(
            function ($server) use ($instance) {
                $instance->addServer($server['host'], $server['port']);
            },
            $servers
        );
        restore_error_handler();
    }

    /**
     * dispatch
     *
     * @return mixed
     */
    public function dispatch()
    {
        set_error_handler(array($this, 'errorHandler'));
        $instance = $this->getGearmanInstance();

        array_map(
            function (JobInterface $job) use ($instance) {
                $instance->doBackground($job->getId(), $job->serialize());
            },
            $this->getJobs()
        );
        restore_error_handler();
    }
}
