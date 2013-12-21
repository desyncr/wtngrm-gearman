<?php
namespace Desyncr\Wtngrm\Gearman\Factory;

use Desyncr\Wtngrm\Factory as Wtngrm;
use Desyncr\Wtngrm\Gearman\Service\GearmanWorkerService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class GearmanWorkerServiceFactory extends Wtngrm\AbstractServiceFactory implements FactoryInterface
{
    protected $configuration_key = 'gearman-adapter';

    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        parent::createService($serviceLocator);

        $gearman = new \GearmanWorker;
        $options = isset($this->config[$this->configuration_key]) ? $this->config[$this->configuration_key] : array();

        return new GearmanWorkerService($gearman, $options);

    }
}
