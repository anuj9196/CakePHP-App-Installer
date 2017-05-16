# Installer plugin for CakePHP

## Version/Update
 **Current Version:** v1.0.0
 
 **Last Update:** May 16, 2017

## Requirements
#### CakePHP: 3.4+

## Introduction
This plugin will allow you to Install your CakePHP Application on other server/system using GUI interface like Wordpress, etc.

## Installation
#### Step 1:
You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require cakephp-app-installer/installer
```
#### Step 2:
load Installer plugin to your CakePHP Application by adding below like to your **bootstrap.php** file inside */config* directory
```
Plugin::load('Installer', ['bootstrap' => true, 'routes' => true]);
```

## Setup
below following script inside **bootstrap.php** file in */config* directory
```
try {
    Configure::config('default', new PhpConfig());
    Configure::load('app', 'default', false);
} catch (\Exception $e) {
    exit($e->getMessage() . "\n");
}
```
add following lines
```
try {
    Configure::load('database_config', 'default');
} catch (\Exception $e) {

}
```

## Running Installer
to run installer, open below url in your browser
```
http://example.com/path_to_app/installer
```
and follow on screen instructions

## Importing Schema
To import schema to the database, follow below steps
#### Step 1:
Export or save your schema to *sql* file
#### Step 2:
Rename file to **my_shema.sql**
#### Step 3:
Copy **my_schema.sql** file to **/config** directory of your application
#### Step 4:
Mark check **Import Database** in **Database Connection Setup** page
#### Step 5:
Installer will automatically import your schema to the database

> **NOTE:** Schema Import may take some time depending on the schema size. Please, do not close the window or refresh the page after clicking **Copy Schema** button

## Important Instruction
1. You may need to give write permission ot */config* directory, because a file will be created inside this directory
1. Please, do not delete **Datasources** array from **app.php** file inside */config* directory. Doing so may break your application.
1. Your **default connection** inside **Datasource** array of **app.php** will be overriden by new database configuration */config/database_config.php*
1. You can still use **Datasources** array to create other connections, only **default** will be overridden.

## Credits
1. @prbaron for providing plugin for old version on CakePHP
2. *Anshuman (my friend)* for asking me to write this plugin
