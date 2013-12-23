<?php
namespace Desyncr\Wtngrm\Gearman\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;

class WorkerController extends AbstractActionController
{
    public function executeAction()
    {
        $request = $this->getRequest();
        if (!$request instanceof ConsoleRequest) {
            throw new \RuntimeException('You can call this action from a webspace');
        }

        $workerName = $this->getRequest()->getParam('workerid');
        $gs = $this->getServiceLocator()->get('Desyncr\Wtngrm\Gearman\Service\GearmanWorkerService');

        $workers = $gs->getOption('workers');

        if (in_array($workerName, array_keys($workers)) && in_array(
            'Desyncr\Wtngrm\Worker\WorkerInterface',
            class_implements($workers[$workerName])
        )) {
            $worker = new $workers[$workerName];
            $sm = $this->getServiceLocator();

            $gs->add(
                $workerName,
                function ($job) use ($worker, $sm) {
                    $worker->execute($job, $sm);
                }
            );

            while ($gs->dispatch()) {
            }
        }
    }
}
