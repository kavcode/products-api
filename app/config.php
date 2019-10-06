<?php
return [
    'database' => [
        'driver' => 'pdo_mysql',
        'path' => getenv(),
        'user' => getenv('MYSQL_USER'),
        'password' => getenv('MYSQL_PASSWORD'),
        'dbname' => getenv('MYSQL_DATABASE'),
        'host' => 'mysql',
    ],
];