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
namespace Desyncr\Wtngrm\Gearman\Factory;

use Desyncr\Wtngrm\Factory as Wtngrm;
use Desyncr\Wtngrm\Gearman\Service\GearmanWorkerService;
use Zend\ServiceManager\FactoryInterface;
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
class GearmanWorkerServiceFactory extends Wtngrm\AbstractServiceFactory implements
    FactoryInterface
{
    /**
     * @var string
     */
    protected $configuration_key = 'gearman-adapter';

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

        $gearman = $serviceLocator
            ->get('Desyncr\Wtngrm\Gearman\Worker\GearmanWorker');

        $options = isset($this->config[$this->configuration_key]) ?
            $this->config[$this->configuration_key] : array();

        return new GearmanWorkerService($gearman, $options);

    }
}
