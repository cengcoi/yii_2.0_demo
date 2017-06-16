<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'demo',
    'name' => 'biketo demo',
    'language'=>'zh-CN',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 's6JGtWwS7OZZZFoDUZDwZIB8q4aIVzng',
        ],
//        'cache' => [
//            'class' => 'yii\caching\FileCache',
//        ],
        'filecache' => [//我们使用CFileCache实现缓存,缓存文件存放在runtime文件夹中
            'class' => 'yii\caching\FileCache',
            'directoryLevel' => 2,//缓存文件的目录深度
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ],
        ],
    ],
    'modules' => [
        'api' => [
            'class' => 'app\modules\api\Module',
        ],
        'backend' => [
            'class' => 'app\modules\backend\Module',
            'defaultRoute' => 'default/login',
        ],
    ],
    'aliases' =>[
        '@uploadsDir'=>dirname(__DIR__).DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR.'uploads',
        '@uploadsUrl'=>'/uploads',
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
