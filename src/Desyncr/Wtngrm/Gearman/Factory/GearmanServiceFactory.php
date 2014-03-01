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

use Desyncr\Wtngrm\Gearman\Service\GearmanService;
use Zend\ServiceManager\FactoryInterface;

/**
 * Desyncr\Wtngrm\Gearman\Factory
 *
 * @category General
 * @package  Desyncr\Wtngrm\Gearman\Factory
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  https://www.gnu.org/licenses/gpl.html GPL-3.0+
 * @link     https://github.com/desyncr
 */
class GearmanServiceFactory extends AbstractGearmanServiceFactory implements
    FactoryInterface
{
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
        return $this->gearmanService ?:
            $this->gearmanService = new GearmanService($gearman, $options);
    }

    /**
     * getGearmanClientService
     *
     * @return mixed
     */
    public function getGearmanClientService()
    {
        return $this->gearmanClientService ?:
            $this->gearmanClientService = $this->getServiceManager()->get(
                'Desyncr\Wtngrm\Gearman\Client\GearmanClient'
            );
    }
}
