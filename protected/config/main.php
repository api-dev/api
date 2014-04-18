<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'API обмена с 1С',
    'sourceLanguage' => 'ru',
    'language' => 'ru',
    'defaultController' => 'default',

    // preloading 'log' component
    'preload' => array('log'),

    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.extensions.*',
    ),

    'modules' => array(
        // uncomment the following to enable the Gii tool
//        'gii' => array(
//            'class' => 'system.gii.GiiModule',
//            'password' => 'admin',
//            // If removed, Gii defaults to localhost only. Edit carefully to taste.
//            'ipFilters' => array('127.0.0.1', '::1'),
//        ),
    ),

    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'class' => 'WebUser',
            'allowAutoLogin' => true,
        ),
        'session' => array(
            'class' => 'HttpSession',
        ),
        // uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
                        'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
//				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

        'db_kp' => array(
            'class' => 'system.db.CDbConnection',
            'connectionString' => 'sqlite:' . dirname(__FILE__) . '/../../../data/generator.db',
            'initSQLs' => array(
                'PRAGMA foreign_keys = ON',
            ),
        ),
        
        'db_auth' => array(
            'class' => 'system.db.CDbConnection',
            'connectionString' => 'sqlite:' . dirname(__FILE__) . '/../../../data/auth.db',
            'initSQLs' => array(
                'PRAGMA foreign_keys = ON',
            ),
        ),

        'db_exch' => array(
            'class' => 'system.db.CDbConnection',
            'connectionString' => 'sqlite:' . dirname(__FILE__) . '/../../../data/exchange.db',
            'initSQLs' => array(
                'PRAGMA foreign_keys = ON',
            ),
        ),

        'db_lbr' => array(
            'class' => 'system.db.CDbConnection',
            'connectionString' => 'sqlite:' . dirname(__FILE__) . '/../../../git-lbr/protected/data/lbr.db',
            'initSQLs' => array(
                'PRAGMA foreign_keys = ON',
            ),
        ),
        'errorHandler' => array(
            'errorAction' => 'default/error',
        ),

        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning, info',
                ),
                // uncomment the following to show log messages on web pages
                /*
                array(
                    'class'=>'CWebLogRoute',
                ),
                */
            ),
        ),
        'cache'=>array(
            'class'=>'system.caching.CMemCache',
            'servers'=>array(
                array(
                    'host'=>'127.0.0.1',
                    'port'=>11211,
                    'weight'=>60,
                )
            ),
        ),
        'authManager'=>array(
            'class'=>'CDbAuthManager',
            'connectionID'=>'db',
        ),
    ),

    'params' => array(
        // this is used in contact page
        'host' => 'lbr.local',
        'adminEmail' => 'webmaster@lbr.ru',
        'timeToCloseInter' => 96,
        'timeToCloseReg' => 8
    ),
);