<?php
/**
 * File for test configuration.
 *
 * @category  Application
 * @package   Configuration
 * @author    Marco Garofalo <garofalo@olomedia.it>
 *
 * @copyright 2012 Olomedia
 * @license   http://www.olomedia.it Licenza
 * @link      http://www.olomedia.it
 */

return CMap::mergeArray(
    require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'main.php'),
    array(
        'components' => array(
            'fixture' => array(
                'class' => 'system.test.CDbFixtureManager'
            ),
            /* uncomment if we require to run commands against test database */
            /*
                'db' => array(
                   'connectionString' => $params['testdb.connectionString'],
                   'username' => $params['testdb.username'],
                   'password' => $params['testdb.password'],
                   'charset' => 'utf8'
               ),
               */

        )
    )
);