<?php
/**
 * File for application params.
 *
 * @category  Application
 * @package   Configuration
 * @author    Marco Garofalo <garofalo@olomedia.it>
 *
 * @copyright 2012 Olomedia
 * @license   http://www.olomedia.it Licenza
 * @link      http://www.olomedia.it
 */

$paramsEnvFile = $backendConfigDir . DIRECTORY_SEPARATOR . (YII_DEBUG ? 'params-dev.php' : 'params-prod.php');
$paramsEnvFileArray = file_exists($paramsEnvFile) ? require($paramsEnvFile) : array();

$paramsCommonFile = $backendConfigDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR .
    'common' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'params.php';

$paramsCommonArray = file_exists($paramsCommonFile) ? require($paramsCommonFile) : array();

return CMap::mergeArray(
    $paramsCommonArray,
    // merge frontend specific with resulting env-local merge *override by local
    CMap::mergeArray(
        array(
            'url.format' => 'path',
            'url.showScriptName' => false,
            'url.rules' => array(
                /* for REST please @see http://www.yiiframework.com/wiki/175/how-to-create-a-rest-api/ */
                /* other @see http://www.yiiframework.com/doc/guide/1.1/en/topics.url */
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
            // add here all frontend-specific parameters
        ),
        // merge environment parameters with local *override by local
        $paramsEnvFileArray
    )
);