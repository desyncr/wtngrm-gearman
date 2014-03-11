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

use Desyncr\Wtngrm\Gearman\Options\GearmanClientOptions;
use Desyncr\Wtngrm\Job\JobBase;
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
class GearmanClientService extends AbstractGearmanService
{
    /**
     * @var array JobInterface
     */
    protected $jobs = array();

    /**
     * Returns a GearmanService instance
     *
     * @param Object               $gearman Gearman Service instance
     * @param GearmanClientOptions $options Options array
     *
     * @throws \Exception
     */
    public function __construct($gearman, GearmanClientOptions $options)
    {
        $this->setOptions($options);
        $this->setGearmanInstance($gearman);

        $servers = $options->getServers('client');
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
     * addJob
     *
     * @param JobInterface $job Job
     *
     * @return mixed
     */
    public function addJob($job)
    {
        array_push($this->jobs, $job);
    }

    /**
     * Add a job to be processed.
     *
     * To be deprecated. Use addJob.
     */
    public function add($key, $job)
    {
        if (!is_object($job)) {
            $job = new JobBase();
            $job->setId($key);
        }
        /** @var JobInterface $job */
        return $this->addJob($job);
    }

    /**
     * getJobs
     *
     * @return array
     */
    public function getJobs()
    {
        return $this->jobs;
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
            function ($job) use ($instance) {
                /** @var JobInterface $job */
                $instance->doBackground(
                    $job->getId(),
                    json_encode($job->serialize())
                );
            },
            $this->getJobs()
        );
        $this->jobs = array();
        restore_error_handler();
    }
}
