<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'enableCookieValidation' => false,
            'enableCsrfValidation'   => false,
            'baseUrl'=>'/api',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'class' => yii\web\User::class,
            'identityClass' => backend\models\User::class,
            'loginUrl' => null,
            'enableAutoLogin' => true,
            'enableSession'=>false,
            'identityCookie'=>['name'=>'_identity-backend','httpOnly'=>true],
        ],
        'authenticator' => [
            'class' => \yii\filters\auth\HttpBearerAuth::class,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'jwt' => [
            'class' => 'backend\components\JwtCom',
            'key' => 'sdfjlskdjgflkdsfhglkwejropkjsdlsdfsd2334213fds',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                'auth'=>'site/login',
                'refresh-token'=>'site/refresh-token',
                'site/check'=>'site/check',
                'OPTIONS' => 'site/index',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'user',
                    'pluralize' => false,
                    'extraPatterns'=>[
                        'GET me'=>'me',
                        'GET track'=>'track',
                        'GET view'=>'view',
                        'GET week'=>'week',
                        'GET month'=>'month',
                        'GET today'=>'today',
                        'GET running'=>'running',
                        'POST report'=>'report',
                    ]
                ],
            ],
        ]

    ],
    'params' => $params,
];
