<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Desyncr\Wtngrm\Gearman\Service\GearmanService'  => 'Desyncr\Wtngrm\Gearman\Factory\GearmanServiceFactory',
            'Desyncr\Wtngrm\Gearman\Service\GearmanWorkerService'  => 'Desyncr\Wtngrm\Gearman\Factory\GearmanWorkerServiceFactory',
            'Desyncr\Wtngrm\Gearman\Client\GearmanClient' => function($sm) {
                return new \GearmanClient();
            },
            'Desyncr\Wtngrm\Gearman\Worker\GearmanWorker' => function($sm) {
                return new \GearmanWorker();
            }
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'Desyncr\Wtngrm\Gearman\Controller\Worker' => 'Desyncr\Wtngrm\Gearman\Controller\WorkerController',
        )
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'gearman_worker_route' => array(
                    'options' => array(
                        'route' => 'gearman worker execute <workerid>',
                        'defaults' => array(
                            '__NAMESPACE__' => 'Desyncr\Wtngrm\Gearman\Controller',
                            'controller' => 'Worker',
                            'action' => 'execute'
                        )
                    )
                )
            )
        )
    ),
);
