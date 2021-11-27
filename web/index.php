<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

header('Access-Control-Allow-Methods: OPTIONS, GET, POST'); // 允许的请求方式
header('Access-Control-Allow-Origin: *');  // 允许的域名
header('Access-Control-Allow-Credentials: true'); // 是否允许携带cookie
header('Access-Control-Allow-Headers: token,content-type'); // 允许的请求头

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
