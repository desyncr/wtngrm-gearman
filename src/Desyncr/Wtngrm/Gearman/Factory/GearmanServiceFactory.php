<?php
namespace Desyncr\Wtngrm\Gearman\Factory;
use Desyncr\Wtngrm\Factory as Wtngrm;
use Desyncr\Wtngrm\Gearman\Service\GearmanService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class GearmanServiceFactory extends Wtngrm\AbstractServiceFactory implements FactoryInterface {
    protected $configuration_key = 'gearman-adapter';

    public function createService(ServiceLocatorInterface $serviceLocator) {

        parent::createService($serviceLocator);

        $options = isset($this->config[$this->configuration_key]) ? $this->config[$this->configuration_key] : array();

        return new GearmanService($options);

    }
}
