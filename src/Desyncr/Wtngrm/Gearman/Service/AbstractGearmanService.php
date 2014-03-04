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
namespace Desyncr\Wtngrm\Gearman\Service;

use Desyncr\Wtngrm\Service\AbstractService;

/**
 * Desyncr\Wtngrm\Gearman\Service
 *
 * @category General
 * @package  Desyncr\Wtngrm\Gearman\Service
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  https://www.gnu.org/licenses/gpl.html GPL-3.0+
 * @link     https://github.com/desyncr
 */
abstract class AbstractGearmanService extends AbstractService
{
    /**
     * @var Object Gearman instance
     */
    protected $instance = null;

    /**
     * setGearmanInstance
     *
     * @param Object $instance Gearman instance
     *
     * @return mixed
     */
    public function setGearmanInstance($instance)
    {
        $this->instance = $instance;
    }

    /**
     * getGearmanInstance
     *
     * @return mixed
     */
    public function getGearmanInstance()
    {
        return $this->instance;
    }

    /**
     * Handle errors and warnings as Exceptions
     * http://stackoverflow.com/a/1241751
     *
     * @param Integer $errno      Error number
     * @param String  $errstr     Error description
     * @param String  $errfile    Source origin
     * @param Integer $errline    Line error
     * @param Array   $errcontext Context
     *
     * @throws \Exception
     * @return mixed
     */
    public function errorHandler(
        $errno,
        $errstr,
        $errfile,
        $errline,
        array $errcontext
    ) {
        throw new \Exception($errstr, $errno);
    }
} 