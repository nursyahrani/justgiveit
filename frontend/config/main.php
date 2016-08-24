<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '867669086677221',
                    'attributeNames' => ['id', 'name', 'email', 'first_name', 'last_name', 'picture'],
                    'clientSecret' => 'd71d780cc455a901ce925d76cf9b2cf9',
                ],

            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],

        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'login' => 'site/login',
                'signup' => 'site/signup',
                'user/<username:[. a-zA-Z 0-9]+>/<request: (.*)>' => 'profile/index',
                'user/<username:[. a-zA-Z 0-9]+>' => 'profile/index',
                'tag/<tag:(.*)>' => 'site/index',
                'post/<id:\d+>/<title:(.*)>' => 'post/index'
                

            ]
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
        'request'=>[
            'class' => 'common\components\Request',
            'web'=> '/frontend/web'
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
    'timeZone' => 'Asia/Singapore'
];
