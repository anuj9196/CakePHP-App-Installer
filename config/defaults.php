<?php
// Default settings for the installer
use Cake\Database\Driver\Mysql;
use Cake\Database\Connection;

return [
    'Installer' => [
        // Default database connection settings
        'Connection' => [
            'className' => Connection::class,
            'driver' => Mysql::class,
            'persistent' => false,
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'database' => 'cakephp',
            'prefix' => '',
            'encoding' => 'utf8',
        ],

        /**
         * These are files that the installer might update. If the 'use' key is set to true, the
         * 'default' file will be copied to the 'filename' and updated with any provided settings
         * as part of the installation process.
         */
        'Files' => [
            // By default, these two config files will be used. database.php is pretty standard,
            // so a default implementation is provided for you in this plugin. You must provide
            // your own default app.php, if you are using it.
            'app_php' => [
                'use' => true,
                'filename' => 'app.php',
                'default' => CONFIG . 'app.default.php',
            ],
            'database_php' => [
                'use' => true,
                'filename' => 'database.php',
                'default' => PLUGIN_CONFIG . 'database.php.install',
            ],

            // These are common optional config files. If you use them, you must provide your own
            // default versions. Your configuration may also add any additional config files that
            // are required for your application. Note that config files that are not expected to
            // change need not be listed here; for example, if your system-specific settings all
            // live in app_local.php and app.php shouldn't be touched, set the 'use' to false in
            // the app_php section above, and simply include your app.php in your config folder,
            // rather than providing an app.default.php to be copied and edited.
            'app_local_php' => [
                'use' => false,
                'filename' => 'app_local.php',
                'default' => CONFIG . 'app_local.default.php',
            ],
            '_env' => [
                'use' => false,
                'filename' => '.env',
                'default' => CONFIG . '.env.default',
            ],
        ],

        'Import' => [
            'ask' => true,
            'schema' => 'schema' . DS . 'my_schema.sql',
            'migrations' => false,
        ],
    ],
];
