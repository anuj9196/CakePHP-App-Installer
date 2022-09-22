# Installation
This documentation page guides you through installation of **CakePHP-App-Installer** plugin into your application

#### Step 1:
You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require cakephp-app-installer/installer
```
#### Step 2:
load Installer plugin to your CakePHP Application by adding below like to your **bootstrap.php** file inside */config* directory
```
Plugin::load('CakePHPAppInstaller', ['bootstrap' => true, 'routes' => true]);
```
or from terminal
```
bin/cake plugin load CakePHPAppInstaller -b -r
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
    Configure::load('database', 'default');
} catch (\Exception $e) {

}
```

#### Automation

You can also configure your application to auto check for database configuration so that any modification in database configuration will redirect user to re-configuration of the database. Fore more guide [Click Here](automation.md)

[< README](../README.md) | [Running Installer >](running-installer.md)
