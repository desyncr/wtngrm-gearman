<?php
namespace Desyncr\Wtngrm\Gearman\Service;
use Desyncr\Wtngrm\Service as Wtngrm;

class GearmanService extends Wtngrm\AbstractService {
    protected $instance = null;
    protected $host = '127.0.0.1';
    protected $port = 4730;

    public function __construct() {
        $this->instance = new \GearmanClient();
        $this->instance->addServer($this->host, $this->port);
    }

    public function dispatch() {
        foreach ($this->jobs as $job) {
            $this->instance->doBackground($job->getId(), json_encode($job->serialize()));
        }
    }
}
