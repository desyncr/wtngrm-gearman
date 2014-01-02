<?php
namespace Desyncr\Wtngrm\Gearman\Worker;

use Desyncr\Wtngrm\Worker\AbstractWorker;

abstract class GearmanWorker extends AbstractWorker
{
    protected $workload = null;

    public function setUp($sm, $job) {
        parent::setUp($sm, $job);
        $this->workload = json_decode($this->job->workload(), true);
    }
}
