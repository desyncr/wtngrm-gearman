<?php
/**
 * Desyncr\Wtngrm\Gearman\Factory
 *
 * PHP version 5.4
 *
 * @category General
 * @package  Desyncr\Wtngrm\Gearman\Factory
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  https://www.gnu.org/licenses/gpl.html GPL-3.0+
 * @version  GIT:<>
 * @link     https://github.com/desyncr
 */
namespace Desyncr\Wtngrm\Gearman\Factory;

use Desyncr\Wtngrm\Gearman\Service\GearmanWorkerService;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\AbstractOptions;

/**
 * Desyncr\Wtngrm\Gearman\Factory
 *
 * @category General
 * @package  Desyncr\Wtngrm\Gearman\Factory
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  https://www.gnu.org/licenses/gpl.html GPL-3.0+
 * @link     https://github.com/desyncr
 */
class GearmanWorkerServiceFactory extends AbstractGearmanServiceFactory
{
    /**
     * getGearmanService
     *
     * @param Object          $gearman Gearman service instance
     * @param AbstractOptions $options Adapter options
     *
     * @return mixed
     */
    public function getGearmanService($gearman, AbstractOptions $options)
    {
        return new GearmanWorkerService($gearman, $options);
    }

    /**
     * getGearmanClientService
     *
     * @param ServiceLocatorInterface $sm Service Locator
     *
     * @return mixed
     */
    public function getGearmanClient(ServiceLocatorInterface $sm)
    {
        return $sm->get(
            'Desyncr\Wtngrm\Gearman\Worker\GearmanWorker'
        );
    }

    /**
     * getGearmanOptions
     *
     * @param ServiceLocatorInterface $sm Service Locator
     *
     * @return mixed
     */
    public function getGearmanOptions(ServiceLocatorInterface $sm)
    {
        return $sm->get(
            'Desyncr\Wtngrm\Gearman\Options\GearmanWorkerOptions'
        );
    }
}
