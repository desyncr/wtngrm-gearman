<?php
/**
 * Wtngrm-gearman configuration
 *
 * PHP version 5.4
 *
 * @category General
 * @package  Desyncr\Wtngrm\Gearman
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  http://gpl.gnu.org GPL-3.0+
 * @version  GIT:<>
 * @link     https://github.com/desyncr
 */
return array(
    /**
     * Configure factories
     */
    'service_manager' => array(
        'factories' => array(
            'Desyncr\Wtngrm\Gearman\Service\GearmanService'  => 'Desyncr\Wtngrm\Gearman\Factory\GearmanServiceFactory',
            'Desyncr\Wtngrm\Gearman\Service\GearmanWorkerService'  => 'Desyncr\Wtngrm\Gearman\Factory\GearmanWorkerServiceFactory',
            'Desyncr\Wtngrm\Gearman\Client\GearmanClient' => function ($sm) {
                return new \GearmanClient();
            },
            'Desyncr\Wtngrm\Gearman\Worker\GearmanWorker' => function ($sm) {
                return new \GearmanWorker();
            }
        ),
    ),

    /**
     * Configure action controlles to launch workers
     */
    'controllers' => array(
        'invokables' => array(
            'Desyncr\Wtngrm\Gearman\Controller\Worker' => 'Desyncr\Wtngrm\Gearman\Controller\WorkerController',
        )
    ),

    /**
     * Configure routes to launch action controllers
     */
    'console' => array(
        'router' => array(
            'routes' => array(
                'gearman_worker_route' => array(
                    'options' => array(
                        'route' => 'gearman worker execute <worker>',
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
