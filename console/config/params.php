<?php
/**
 * File for application paramas.
 *
 * @category  Application
 * @package   Configuration
 * @author    Marco Garofalo <garofalo@olomedia.it>
 * @author    antonio ramirez <antonio@clevertech.biz>
 * @copyright 2012 Olomedia
 * @license   http://www.olomedia.it Licenza
 * @link      http://www.olomedia.it
 */

$paramsEnvFile = $consoleConfigDir . DIRECTORY_SEPARATOR . (YII_DEBUG ? 'params-dev' : 'params-prod.php');
$paramsEnvFileArray = file_exists($paramsEnvFile) ? require($paramsEnvFile) : array();

$paramsCommonFile = $consoleConfigDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR .
    'common' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'params.php';

$paramsCommonArray = file_exists($paramsCommonFile) ? require($paramsCommonFile) : array();

return CMap::mergeArray(
    $paramsCommonArray,
    // merge console specific with resulting env-local merge *override by local
    CMap::mergeArray(
        array(// add here all console-specific parameters
        ),
        // merge environment parameters with local *override by local
        $paramsEnvFileArray
    )
);