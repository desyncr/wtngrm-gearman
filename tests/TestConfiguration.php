<?php
/**
 * Desyncr\Wtngrm\Gearman
 *
 * PHP version 5.4
 *
 * @category General
 * @package  Desyncr\Wtngrm\Gearman
 * @author   Dario Cavuotti <dc@syncr.com.ar>
 * @license  https://www.gnu.org/licenses/gpl.html GPL-3.0+
 * @version  GIT:<>
 * @link     https://github.com/desyncr
 */
return array(
    'modules' => array(
        'Wtngrm\\Gearman',
    ),
    'module_listener_options' => array(
        'config_glob_paths' => array(
            __DIR__ . '/testing.config.php',
        ),
        'module_paths' => array(),
    ),
);
