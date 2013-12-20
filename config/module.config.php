<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Desyncr\Wtngrm\Gearman\Controller\Worker'    => 'Desyncr\Wtngrm\Gearman\Controller\WorkerController',
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
