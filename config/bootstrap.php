<?php
use Cake\Core\Configure;
/**
 * Path constants
 */
    define('PLUGIN_CONFIG', dirname(__DIR__) . DS . 'config' .DS);
/**
 * Database installation variable
 * if set to TRUE, the database is installed
 * if set to FALSE, the databse is not installed
 */
    Configure::write('Database.installed', false);

    Configure::load('Installer.defaults');
    collection((array)Configure::read('Installer.config'))->each(function ($file) {
        Configure::load($file);
    });
