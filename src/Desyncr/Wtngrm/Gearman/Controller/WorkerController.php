<?php
namespace Desyncr\Wtngrm\Gearman\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;

class WorkerController extends AbstractActionController {
    public function executeAction() {
        $request = $this->getRequest();
        if (!$request instanceof ConsoleRequest) {
            throw new \RuntimeException('You can call this action from a webspace');
        }

        $worker = $this->getRequest()->getParam('workerid');
        $gs = $this->getServiceLocator()->get('Desyncr\Wtngrm\Gearman\Service\GearmanService');

        $workers = $gs->getOption('workers');

        if (in_array($worker, array_keys($workers)) && in_array('Desyncr\Wtngrm\Worker\WorkerInterface', class_implements($workers[$worker]))) {
            $gs->register($worker, $workers[$worker] . '::execute');

            while($gs->work()) {}
        }
    }
}
