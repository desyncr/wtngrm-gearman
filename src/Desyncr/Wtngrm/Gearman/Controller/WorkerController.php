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
namespace Desyncr\Wtngrm\Gearman\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;

/**
 * Desyncr\Wtngrm\Gearman\Controller
 *
 * @category General
 * @package  Desyncr\Wtngrm\Gearman\Controller
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  https://www.gnu.org/licenses/gpl.html GPL-3.0+
 * @link     https://github.com/desyncr
 */
class WorkerController extends AbstractActionController
{
    /**
     * executeAction
     *
     * @return mixed
     * @throws \RuntimeException
     */
    public function executeAction()
    {
        $request = $this->getRequest();
        if (!$request instanceof ConsoleRequest) {
            throw new \RuntimeException('You can call this action from web');
        }

        $workerName = $this->getRequest()->getParam('workerid');
        $worker = $this->_getWorker($workerName);

        $this->_dispatchWorker($workerName, $worker);
    }

    /**
     * _dispatchWorker
     *
     * @param String   $workerName Worker ID
     * @param Callable $worker     Worker instance
     */
    private function _dispatchWorker($workerName, $worker)
    {
        $serviceLocator = $this->getServiceLocator();
        $gearmanService = $serviceLocator
            ->get('Desyncr\Wtngrm\Gearman\Service\GearmanWorkerService');

        $gearmanService->add(
            $workerName,
            function ($job) use ($worker, $serviceLocator) {
                $worker->setUp($serviceLocator, $job);
                $worker->execute($job);
                $worker->tearDown();
            }
        );

        while ($gearmanService->dispatch()) {
        }
    }

    /**
     * Gets a new instance of a given worker
     *
     * @param String $workerName Worker id defined into configuration
     *
     * @return Object
     * @throws \Exception
     */
    private function _getWorker($workerName)
    {
        $serviceLocator = $this->getServiceLocator();
        $gearmanService = $serviceLocator
            ->get('Desyncr\Wtngrm\Gearman\Service\GearmanWorkerService');

        $workers = $gearmanService->getOption('workers');
        if (!in_array($workerName, array_keys($workers))) {
            throw new \Exception('Worker ID not found or not defined!');
        }

        if (!in_array(
            'Desyncr\Wtngrm\Worker\WorkerInterface',
            class_implements($workers[$workerName])
        )) {
            throw new \Exception(
                'Worker class doesn\'t implements Desyncr\Wtngrm\Worker\WorkerInterface'
            );
        }

        return new $workers[$workerName];
    }
}
