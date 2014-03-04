<?php
/**
 * Desyncr\Wtngrm\Gearman\Worker
 *
 * PHP version 5.4
 *
 * @category General
 * @package  Desyncr\Wtngrm\Gearman\Worker
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  https://www.gnu.org/licenses/gpl.html GPL-3.0+
 * @version  GIT:<>
 * @link     https://github.com/desyncr
 */
namespace Desyncr\Wtngrm\Gearman\Worker;

use Desyncr\Wtngrm\Worker\AbstractWorker;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Desyncr\Wtngrm\Gearman\Worker
 *
 * @category General
 * @package  Desyncr\Wtngrm\Gearman\Worker
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  https://www.gnu.org/licenses/gpl.html GPL-3.0+
 * @link     https://github.com/desyncr
 */
abstract class GearmanWorker extends AbstractWorker
{
    /**
     * @var Array
     */
    protected $workload = array();

    /**
     * setUp
     *
     * @param ServiceLocatorInterface $sm  Service locator instance
     * @param \GearmanJob             $job Gearman job
     *
     * @return null
     */
    public function setUp(ServiceLocatorInterface $sm, $job)
    {
        parent::setUp($sm, $job);

        /** @var \GearmanJob $job */
        if (is_object($job)) {
            // HACK for gearmand version ~0.2
            $workload = json_decode($job->workload(), true);
        } else {
            $workload = $job;
        }

        $this->setWorkload($workload);
    }

    /**
     * setWorkload
     *
     * @param Array $workload Workload
     *
     * @return null
     */
    public function setWorkload(Array $workload)
    {
        $this->workload = $workload;
    }

    /**
     * getWorkload
     *
     * @return array
     */
    public function getWorkload()
    {
        return $this->workload;
    }
}
