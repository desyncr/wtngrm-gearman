<?php
/**
 * Desyncr\Wtngrm\Gearman\Controller
 *
 * PHP version 5.4
 *
 * @category General
 * @package  Desyncr\Wtngrm\Gearman\Controller
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  https://www.gnu.org/licenses/gpl.html GPL-3.0+
 * @version  GIT:<>
 * @link     https://github.com/desyncr
 */
namespace Desyncr\Wtngrm\Gearman\Controller;

use Desyncr\Wtngrm\Gearman\Worker\GearmanWorker;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;
use Desyncr\Wtngrm\Worker\WorkerInterface;
use Desyncr\Wtngrm\Gearman\Service\GearmanWorkerService;
use Desyncr\Wtngrm\Gearman\Options\GearmanWorkerOptions;

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
     * @var GearmanWorkerService GearmanService instance
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
     * @param String        $workerName Worker ID
     * @param GearmanWorker $worker     Worker instance
     *
     * @return null
     */
    private function _dispatchWorker($workerName, GearmanWorker $worker)
    {
        $serviceLocator = $this->getServiceLocator();
        $gearmanService = $this->getGearmanService();

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
     * @return \Desyncr\Wtngrm\Worker\WorkerInterface
     * @throws \Exception
     */
    private function _getWorker($workerName)
    {
        /** @var GearmanWorkerOptions $options */
        $options = $this->getServiceLocator()->get('Config');
        $workers = $options['gearman']['workers'];
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
     * @param GearmanWorkerService $gearmanService Gearman service instance
     *
     * @return mixed
     */
    public function setGearmanService(GearmanWorkerService $gearmanService)
    {
        $this->gearmanService = $gearmanService;
    }

    /**
     * getGearmanService
     *
     * @return GearmanWorkerService
     */
    public function getGearmanService()
    {
        return $this->gearmanService ?:
            $this->gearmanService = $this->getServiceLocator()->get(
                'Desyncr\Wtngrm\Gearman\Service\GearmanWorkerService'
            );
    }
}
