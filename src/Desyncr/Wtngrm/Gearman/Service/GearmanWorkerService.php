<?php
namespace Desyncr\Wtngrm\Gearman\Service;

use Desyncr\Wtngrm\Service as Wtngrm;

class GearmanWorkerService extends Wtngrm\AbstractService
{
    protected $worker = null;

    public function __construct($options)
    {
        $this->setOptions($options);

        $this->instance = new \GearmanWorker();
        foreach ($this->servers['workers'] as $server) {
            $this->instance->addServer($server['host'], $server['port']);
        }
    }

    public function add($function, $worker, $target = null)
    {
        if (!$this->worker) {
            $this->worker = new \GearmanWorker();
            foreach ($this->servers['workers'] as $server) {
                $this->worker->addServer($server['host'], $server['port']);
            }
        }

        $this->worker->addFunction($function, $worker);
    }

    public function dispatch()
    {
        try {
            $res = $this->worker->work();
        } catch (\Exception $e) {
            return false;
        }

        return $res;
    }
}
