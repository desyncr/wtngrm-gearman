<?php
namespace Desyncr\Wtngrm\Gearman\Service;
use Desyncr\Wtngrm\Service as Wtngrm;

class GearmanWorkerService extends Wtngrm\AbstractService {
    protected $instance = null;

    public function __construct($gearman, $options) {
        $this->setOptions($options);
        $this->instance = $gearman;

        if (!count($this->servers['workers'])) {
            throw new \Exception('Define at least a worker Gearman server.');
        }

        foreach ($this->servers['workers'] as $server) {
            $this->instance->addServer($server['host'], $server['port']);
        }
    }

    public function add($function, $worker) {
        $this->instance->addFunction($function, $worker);
    }

    public function dispatch() {
        return $this->instance->work();
    }
}
