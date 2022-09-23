<?php

use Cake\Database\Driver\Mysql;
use Cake\Database\Connection;

return [
    'Datasources' => [
        'default' => [
            'className' => Connection::class,
            'driver' => Mysql::class,
            'persistent' => false,
            'host' => '{default_host}',
            /**
            * CakePHP will use the default DB port based on the driver selected
            * MySQL on MAMP uses port 8889, MAMP users will want to uncomment
            * the following line and set the port accordingly
            */
            //'port' => 'non_standard_port_number',
            'username' => '{default_username}',
            'password' => '{default_password}',
            'database' => '{default_database}',
            'encoding' => 'utf8',
            'timezone' => 'UTC',
            'flags' => [],
            'cacheMetadata' => true,
            'log' => false,
        ]
    ]
];
