<?php
/**
 * Desyncr\Wtngrm\Gearman\Options
 *
 * PHP version 5.4
 *
 * @category General
 * @package  Desyncr\Wtngrm\Gearman\Options
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  https://www.gnu.org/licenses/gpl.html GPL-3.0+
 * @version  GIT:<>
 * @link     https://github.com/desyncr
 */
namespace Desyncr\Wtngrm\Gearman\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Class GearmanOptions
 *
 * @category General
 * @package  Desyncr\Wtngrm\Gearman\Options
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  https://www.gnu.org/licenses/gpl.html GPL-3.0+
 * @link     https://github.com/desyncr
 */
class GearmanOptions extends AbstractOptions
{
    /**
     * @var array
     */
    protected $servers;

    /**
     * getServers
     *
     * @param string $type Either worker or client
     * @return Array
     */
    public function getServers($type = null)
    {
        if ($type) {
            return $this->servers[$type];
        }
        return $this->servers;
    }

    /**
     * setServers
     *
     * @param Array $servers Servers array
     *
     * @return mixed
     */
    public function setServers($servers)
    {
        $this->servers = $servers;
    }
}
 