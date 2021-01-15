<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class'     =>  'yii\log\FileTarget',
                    'levels'    =>  ['error', 'warning','info'],
                    'logVars'   =>  [],
                    'categories'=>  ['yii\db\*','app\models\*'],
                    //表示写入到文件
                    'logFile'=>'@runtime/../runtime/logs/YIISQL_'.date('y_m_d').'.log',
                ]
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
    'controllerMap' =>  [
        'swoole-backend' => [
            'class' => feehi\console\SwooleController::className(),
            'rootDir' => __DIR__.'/..',//yii2项目根路径
            'app' => '',
            'host' => '0.0.0.0',
            'port' => 9998,
            'web' => 'web',//默认为web。rootDir app web目的是拼接yii2的根目录，如果你的应用为basic，那么app为空即可。
            'debug' => true,//默认开启debug，上线应置为false
            'env' => 'dev',//默认为dev，上线应置为prod
            'type'  =>  'basic',
            'swooleConfig' => [
                'reactor_num' => 2,
                'worker_num' => 4,
                'daemonize' => false,
                'log_file' => __DIR__ . '/../runtime/logs/swoole.log',
                'log_level' => 0,
                'pid_file' => __DIR__ . '/../runtime/server.pid',
            ],
        ]
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];

    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => [
            '*'
        ],
    ];
}

return $config;
