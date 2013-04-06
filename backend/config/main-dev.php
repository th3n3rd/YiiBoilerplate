<?php
/**
 * File for main development configuration.
 *
 * @category  Application
 * @package   Configuration
 * @author    Marco Garofalo <garofalo@olomedia.it>
 * @author    antonio ramirez <antonio@clevertech.biz>
 * @copyright 2012 Olomedia
 * @license   http://www.olomedia.it Licenza
 * @link      http://www.olomedia.it
 */

return array(
    'components' => array(
//		'db'=> array(
//			'connectionString' => $params['db.connectionString'],
//			'username' => $params['db.username'],
//			'password' => $params['db.password'],
//			'schemaCachingDuration' => YII_DEBUG ? 0 : 86400000, // 1000 days
//			'enableParamLogging' => YII_DEBUG,
//			'charset' => 'utf8'
//		),
        'urlManager' => array(
            'urlFormat' => $params['url.format'],
            'showScriptName' => $params['url.showScriptName'],
            'rules' => $params['url.rules']
        )
    )
);