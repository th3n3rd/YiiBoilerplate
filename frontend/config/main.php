<?php
/**
 * File for main configuration.
 *
 * @category  Application
 * @package   Configuration
 * @author    Marco Garofalo <garofalo@olomedia.it>
 * @author    antonio ramirez <antonio@clevertech.biz>
 * @copyright 2012 Olomedia
 * @license   http://www.olomedia.it Licenza
 * @link      http://www.olomedia.it
 */

$frontendConfigDir = dirname(__FILE__);

$root = $frontendConfigDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';

$params = require_once($frontendConfigDir . DIRECTORY_SEPARATOR . 'params.php');

// Setup some default path aliases. These alias may vary from projects.
Yii::setPathOfAlias('root', $root);
Yii::setPathOfAlias('common', $root . DIRECTORY_SEPARATOR . 'common');
Yii::setPathOfAlias('frontend', $root . DIRECTORY_SEPARATOR . 'frontend');
Yii::setPathOfAlias('www', $root . DIRECTORY_SEPARATOR . 'frontend' . DIRECTORY_SEPARATOR . 'www');

$mainEnvFile = $frontendConfigDir . DIRECTORY_SEPARATOR . (YII_DEBUG ? 'main-dev' : 'main-prod.php');
$mainEnvConfiguration = file_exists($mainEnvFile) ? require($mainEnvFile) : array();

return CMap::mergeArray(
    array(
        // @see http://www.yiiframework.com/doc/api/1.1/CApplication#basePath-detail
        'basePath' => 'frontend',
        // set parameters
        'params' => $params,
        // preload components required before running applications
        // @see http://www.yiiframework.com/doc/api/1.1/CModule#preload-detail
        'preload' => array('log'),
        // @see http://www.yiiframework.com/doc/api/1.1/CApplication#language-detail
        'language' => 'en',
        // uncomment if a theme is used
        /*'theme' => '',*/
        // setup import paths aliases
        // @see http://www.yiiframework.com/doc/api/1.1/YiiBase#import-detail
        'import' => array(
            'common.components.*',
            'common.extensions.*',
            'common.models.*',
            // uncomment if behaviors are required
            // you can also import a specific one
            /* 'common.extensions.behaviors.*', */
            // uncomment if validators on common folder are required
            /* 'common.extensions.validators.*', */
            'application.components.*',
            'application.controllers.*',
            'application.models.*'
        ),
        /* uncomment and set if required */
        // @see http://www.yiiframework.com/doc/api/1.1/CModule#setModules-detail
        /* 'modules' => array(), */
        'components' => array(
            'errorHandler' => array(
                // @see http://www.yiiframework.com/doc/api/1.1/CErrorHandler#errorAction-detail
                'errorAction' => 'site/error'
            ),
//			'db' => array(
//				'connectionString' => $params['db.connectionString'],
//				'username' => $params['db.username'],
//				'password' => $params['db.password'],
//				'schemaCachingDuration' => YII_DEBUG ? 0 : 86400000, // 1000 days
//				'enableParamLogging' => YII_DEBUG,
//				'charset' => 'utf8'
//			),
            'urlManager' => array(
                'urlFormat' => 'path',
                'showScriptName' => false,
                'urlSuffix' => '/',
                'rules' => $params['url.rules']
            ),
            /* make sure you have your cache set correctly before uncommenting */
            /* 'cache' => $params['cache.core'], */
            /* 'contentCache' => $params['cache.content'] */
        ),
    ),
    $mainEnvConfiguration
);