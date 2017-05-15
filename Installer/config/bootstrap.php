<?php
use Cake\Core\Configure;
/**
 * Path constants
 */
	define('PLUGIN_CONFIG', ROOT. 'plugins' .DS. 'Installer' .DS. 'config' .DS);
/**
 * Database installation variable
 * if set to TRUE, the database is installed
 * if set to FALSE, the databse is not installed
 */
	Configure::write('Database.installed', false);
