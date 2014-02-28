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

/**
 * Desyncr\Wtngrm\Gearman\Service
 *
 * @category General
 * @package  Desyncr\Wtngrm\Gearman\Service
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  https://www.gnu.org/licenses/gpl.html GPL-3.0+
 * @link     https://github.com/desyncr
 */
class GearmanService extends AbstractGearmanService
{
    /**
     * @var null
     */
    protected $instance = null;

    /**
     * Returns a GearmanService instance
     *
     * @param Object $gearman Gearman Service instance
     * @param Array  $options Options array
     *
     * @throws \Exception
     */
    public function __construct($gearman, $options)
    {
        $this->setOptions($options);
        $this->instance = $gearman;

        if (!count($this->servers['client'])) {
            throw new \Exception('Define at least a client Gearman server.');
        }

        set_error_handler(array($this, 'errorHandler'));
        foreach ($this->servers['client'] as $server) {
            @$this->instance->addServer($server['host'], $server['port']);
        }
        restore_error_handler();
    }

    /**
     * dispatch
     *
     * @return mixed
     */
    public function dispatch()
    {
        set_error_handler(array($this, 'errorHandler'));
        foreach ($this->jobs as $job) {
            @$this->instance->doBackground($job->getId(), $job->serialize());
        }
        restore_error_handler();
    }
}
