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

use Desyncr\Wtngrm\Gearman\Options\GearmanClientOptions;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class GearmanClientOptionsFactory
 *
 * @category General
 * @package  Desyncr\Wtngrm\Gearman\Factory
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  https://www.gnu.org/licenses/gpl.html GPL-3.0+
 * @link     https://github.com/desyncr
 */
class GearmanClientOptionsFactory
{
    /**
     * createService
     *
     * @param ServiceLocatorInterface $serviceLocator Service locator instance
     *
     * @return GearmanClientOptions
     */
    public function createService(ServiceLocatorInterface$serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        return new GearmanClientOptions($config['wtngrm']['gearman-adapter']);
    }
}
 