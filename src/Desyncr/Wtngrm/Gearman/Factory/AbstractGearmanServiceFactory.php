<?php
/**
 * Desyncr\Wtngrm\Gearman\Factory
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
namespace Desyncr\Wtngrm\Gearman\Factory;

use Desyncr\Wtngrm\Gearman\Service\GearmanWorkerService;
use Zend\ServiceManager\FactoryInterface;
use Desyncr\Wtngrm\Factory\AbstractServiceFactory;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Desyncr\Wtngrm\Gearman\Factory
 *
 * @category General
 * @package  Desyncr\Wtngrm\Gearman\Factory
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  https://www.gnu.org/licenses/gpl.html GPL-3.0+
 * @link     https://github.com/desyncr
 */
abstract class AbstractGearmanServiceFactory extends AbstractServiceFactory
    implements FactoryInterface
{
    /**
     * @var string
     */
    protected $adapter = 'gearman';

    /**
     * @var null
     */
    protected $gearmanService = null;

    /**
     * @var null
     */
    protected $gearmanClientService = null;

    /**
     * createService
     *
     * @param ServiceLocatorInterface $serviceLocator Service locator instance
     *
     * @return array|GearmanWorkerService|mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        parent::createService($serviceLocator);

        $gearman = $this->getGearmanClientService();
        $options = $this->getAdapterConfiguration($this->getAdapterKey());

        return $this->getGearmanService($gearman, $options);
    }

    /**
     * getGearmanService
     *
     * @param Object $gearman Gearman service instance
     * @param Array  $options Adapter options
     *
     * @return mixed
     */
    public function getGearmanService($gearman, $options)
    {
        return $this->gearmanService;
    }

    /**
     * setGearmanService
     *
     * @param Object $gearmanService Gearman Service
     *
     * @return mixed
     */
    public function setGearmanService($gearmanService)
    {
        $this->gearmanService = $gearmanService;
    }

    /**
     * getGearmanClientService
     *
     * @return mixed
     */
    public function getGearmanClientService()
    {
        return $this->gearmanClientService;
    }

    /**
     * setGearmanClientService
     *
     * @param Object $gearmanClientService Gearman Client Service
     *
     * @return mixed
     */
    public function setGearmanClientService($gearmanClientService)
    {
        $this->gearmanClientService = $gearmanClientService;
    }

    /**
     * getAdapterKey
     *
     * @return mixed
     */
    public function getAdapterKey()
    {
        return $this->adapter;
    }

    /**
     * setAdapterKey
     *
     * @param String $adapter Adapter configuration key
     *
     * @return mixed
     */
    public function setAdapterKey($adapter)
    {
        $this->adapter = $adapter;
    }
}
