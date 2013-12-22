<?php
namespace Desyncr\Wtngrm\Gearman\Service;
use Desyncr\Wtngrm\Service as Wtngrm;

class GearmanService extends Wtngrm\AbstractService {
    protected $instance = null;
    protected $servers = array('client' => array());

    public function __construct($gearman, $options) {
        $this->setOptions($options);

        $this->instance = $gearman;
        if (!count($this->servers['client'])) {
            throw new \Exception('Define at least a client Gearman server.');
        }

        foreach ($this->servers['client'] as $server) {
            $this->instance->addServer($server['host'], $server['port']);
        }
    }

    public function dispatch() {
        foreach ($this->jobs as $job) {
            $this->instance->doBackground($job->getId(), json_encode($job->serialize()));
        }
    }
}
