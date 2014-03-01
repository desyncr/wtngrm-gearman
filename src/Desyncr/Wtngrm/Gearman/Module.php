<?php
/**
 * Desyncr\Wtngrm\Gearman
 *
 * PHP version 5.4
 *
 * @category General
 * @package  Desyncr\Wtngrm\Gearman
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  https://www.gnu.org/licenses/gpl.html GPL-3.0+
 * @version  GIT:<>
 * @link     https://github.com/desyncr
 */
namespace Desyncr\Wtngrm\Gearman;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

/**
 * Class Module
 *
 * @category General
 * @package  Desyncr\Wtngrm\Gearman
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  https://www.gnu.org/licenses/gpl.html GPL-3.0+
 * @link     https://github.com/desyncr
 */
class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface
{
    /**
     * getAutoloaderConfig
     *
     * @return Array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespace' => array(__NAMESPACE__ => __DIR__)
            )
        );
    }

    /**
     * getConfig
     *
     * @return Array
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../../../config/module.config.php';
    }

    /**
     * getServiceConfig
     *
     * @return Array
     */
    public function getServiceConfig()
    {
        return array(
            'servers' => array(
                'client' => array(
                    'host' => '127.0.0.1',
                    'port' => 4730,
                ),
                'workers' => array(
                    'host' => '127.0.0.1',
                    'port' => 4730,
                )
            )
        );
    }
}
