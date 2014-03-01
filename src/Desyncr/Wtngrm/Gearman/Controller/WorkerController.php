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
use Desyncr\Wtngrm\Worker\WorkerInterface;
use Desyncr\Wtngrm\Service\ServiceInterface;

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
     * @var Object GearmanService instance
     */
    protected $gearmanService = null;

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

        $workerName = $this->getRequest()->getParam('worker');
        $worker = $this->_getWorker($workerName);

        $this->_dispatchWorker($workerName, $worker);
    }

    /**
     * _dispatchWorker
     *
     * @param String                                 $workerName Worker ID
     * @param \Desyncr\Wtngrm\Worker\WorkerInterface $worker     Worker instance
     *
     * @return null
     */
    private function _dispatchWorker($workerName, WorkerInterface $worker)
    {
        $serviceLocator = $this->getServiceLocator();
        $gearmanService = $this->getGearmanService();

        $gearmanService->add(
            $workerName,
            function ($job) use ($worker, $serviceLocator) {
                $worker->setUp($serviceLocator, $job);
                $worker->execute($job, $serviceLocator);
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
     * @return \Desyncr\Wtngrm\Worker\WorkerInterface
     * @throws \Exception
     */
    private function _getWorker($workerName)
    {
        $workers = $this->getGearmanService()->getOption('workers');
        if (!in_array($workerName, array_keys($workers))) {
            throw new \Exception('Worker ID not found or not defined!');
        }

        $interface = 'Desyncr\Wtngrm\Worker\WorkerInterface';
        if (!in_array($interface, class_implements($workers[$workerName]))) {
            throw new \Exception(
                'Worker class doesn\'t implements ' . $interface
            );
        }

        return new $workers[$workerName];
    }

    /**
     * setGearmanService
     *
     * @param ServiceInterface $gearmanService Gearman service instance
     *
     * @return mixed
     */
    public function setGearmanService(ServiceInterface $gearmanService)
    {
        $this->gearmanService = $gearmanService;
    }

    /**
     * getGearmanService
     *
     * @return ServiceInterface
     */
    public function getGearmanService()
    {
        return $this->gearmanService ?:
            $this->gearmanService = $this->getServiceLocator()->get(
                'Desyncr\Wtngrm\Gearman\Service\GearmanWorkerService'
            );
    }
}
