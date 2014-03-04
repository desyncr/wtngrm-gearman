<?php
/**
 * Desyncr\Wtngrm\GearmanTest
 *
 * PHP version 5.4
 *
 * @category General
 * @package  Desyncr\Wtngrm\GearmanTest
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  https://www.gnu.org/licenses/gpl.html GPL-3.0+
 * @version  GIT:<>
 * @link     https://github.com/desyncr
 */
namespace Desyncr\Wtngrm\GearmanTest;

use PHPUnit_Framework_TestCase;
use Desyncr\Wtngrm\Module;

/**
 * @covers Desyncr\Wtngrm\Gearman\Module
 */
class ModuleTest extends PHPUnit_Framework_TestCase
{
    /**
     * testGetAutoloaderConfig
     *
     * @return  null
     */
    public function testGetAutoloaderConfig()
    {
        $module = new Module();
        // just testing ZF specification requirements
        $this->assertInternalType('array', $module->getAutoloaderConfig());
    }

    /**
     * testGetConfig
     *
     * @return mixed
     */
    public function testGetConfig()
    {
        $module = new Module();
        // just testing ZF specification requirements
        $this->assertInternalType('array', $module->getConfig());
    }
}
