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
namespace Desyncr\Wtngrm\Gearman\Worker;

use Desyncr\Wtngrm\Worker\AbstractWorker;

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
     * @var null
     */
    protected $workload = null;

    /**
     * setUp
     *
     * @param Object $sm  Service locator instance
     * @param Object $job Gearman job
     *
     * @return mixed
     */
    public function setUp($sm, $job)
    {
        parent::setUp($sm, $job);

        /* HACK for gearmand version ~0.2 */
        if (is_object($this->job)) {
            $this->workload = json_decode($this->job->workload(), true);
        } else {
            $this->workload = $this->job;
        }
    }
}
