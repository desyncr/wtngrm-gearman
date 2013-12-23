<?php
namespace Desyncr\Wtngrm\Gearman\Service;

use Desyncr\Wtngrm\Service as Wtngrm;

class GearmanService extends Wtngrm\AbstractService
{
    protected $instance = null;

    public function __construct($options)
    {
        $this->setOptions($options);

        $this->instance = new \GearmanClient();
        foreach ($this->servers['client'] as $server) {
            $this->instance->addServer($server['host'], $server['port']);
        }
    }

    public function dispatch()
    {
        foreach ($this->jobs as $job) {
            $this->instance->doBackground($job->getId(), json_encode($job->serialize()));
        }
    }
}
