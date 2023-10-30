<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        //UTILIZANDO A CLASSE DB MANAGER AQUI ENCONTRA-SE A CONFIGURAÇÃO DO authManager
        'authManager' => [
            'class' => \yii\rbac\DbManager::class,
        ],
        // DBManager: Armazena as regras de acesso em tabelas de uma BD - IMPORTANTE
    ],
];
