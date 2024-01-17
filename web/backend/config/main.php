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
    'modules' => [
        'api' => [
            'class' => 'backend\modules\api\APIModule',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'multipart/form-data' => 'yii\web\MultipartFormDataParser',
                ],
                'acceptableContentTypes' => [
                    'application/json' => 1,
                ],

        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            //'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'api/user',
                    'extraPatterns' => [
                        'POST login' => 'login',
                        'POST registo' => 'registo',
                        'PUT atualizarpassword/{id}' => 'atualizarpassword',
                        'GET data' => 'data',
                        'PUT editar' => 'editar',
                        'PUT atualizarpassword' => 'atualizarpassword',
                    ],

                ],
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'api/perfil',
                    'extraPatterns' => [
                        'PUT atualizar/{id}' => 'atualizar',
                        'GET index' => 'index',
                        'GET view' => 'view',

                    ],

                ],

                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'api/artigo',
                    'extraPatterns' => [
                        'GET index' => 'index',

                    ],

                ],

                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'api/fatura',
                    'extraPatterns' => [
                        'GET find' => 'find',
                        'GET detalhes/{id}' => 'detalhes',
                        'GET comprarcarrinho' => 'comprarcarrinho',
                        'PUT pagar/{id}' => 'pagar',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'api/avaliacao',
                    'extraPatterns' => [
                        'GET ver/{id}' => 'ver',//ver todas as avaliacoes de um artigo
                        'POST criar' => 'criar',
                        'GET index' => 'index',
                        'GET byuser' => 'byuser',
                        'DELETE remover' => 'remover',
                        'PUT editar' => 'editar',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'api/carrinho',
                    'extraPatterns' => [
                        'GET index/{id}' => 'index',
                        'POST create' => 'create',
                        'POST adicionar' => 'adicionar',
                        'GET byuser' => 'byuser',
                        'DELETE limparcarrinho' => 'limparcarrinho',
                        'DELETE limparlinhacarrinho' => 'limparlinhacarrinho',
                        'PUT atualizar' => 'atualizar',
                       // 'POST create/{id}/{idartigo}' => 'create',
                       // 'POST create/<idperfil:\d+>/<idartigo:\d+>' => 'create',
                    ],

                    /*'tokens' => [
                        '{idperfil}' => '<idperfil:\\d+>',
                        '{idartigo}' => '<idartigo:\\d+>',
                    ],*/
                ],
                ['class' => 'yii\rest\UrlRule',
                    'controller' => 'api/favorito',
                    'extraPatterns' => [
                        'GET index/{id}' => 'index',
                        'POST adicionar' => 'adicionar',
                        'DELETE remove/{id}' => 'remove',
                        'GET byuser' => 'byuser',
                        'DELETE limparfavoritos' => 'limparfavoritos',
                        'GET passarfavoritoscarrinho' => 'passarfavoritoscarrinho',
                        'GET adicionafavoritocarrinho' => 'adicionafavoritocarrinho',
                        'DELETE limparfavorito' => 'limparfavorito',
                    ],
                ],
            ],
        ],
    ],
];
