<?php
return [
    'id' => 'id',
    'basePath' => __DIR__,
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'pgsql:host=localhost;dbname=grnrbt_censored_test',
            'username' => 'grnrbt_censored_test',
            'password' => 'pass',
            'charset' => 'utf8',
        ],
    ],
];