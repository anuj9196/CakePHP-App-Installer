# Automation of Plugin

This documentation will guide you through how to configure your application for automatic database configuration

### What this means?
After installing application on the server, there could be some changes to database server, login creadentials, etc which leads in break down of your application.
Configuring automatic task of CakePHP-App-Installer plugin will let you re-configure your application whenever there is a failure

### What it checks for?
It will check for whether database connection could be established or not. Failure can be due to following reasons
* change in database host
* change in password of user
* change in user of the database
* deletion of user from database
* deletion of database from server
* accidental modification to database configuration file of application

### What will happen then?
Your application may break down and couldn't be loaded giving a 505 error

### What will the plugin do?
Plugin will autocheck for database configuration and let you re-configure database in case of database connectivity failure.

### What I need to do?
Add following lines to your `beforeRender` function of **AppController.php**

```
$this->loadComponent('Installer.Install');
if ($this->request->params['plugin'] !== 'Installer') {
   $this->Install->installationCheck();
}
```

Your `beforeRender` function then looks like
```
    public function beforeRender(Event $event)
    {
        $this->loadComponent('Installer.Install');
        if ($this->request->params['plugin'] !== 'Installer') {
            $this->Install->installationCheck();
        }
        ...
        ...
        ...
    }
 ```
 
 **That's it** Now whenever there is database connectivity failure, you will be asked to reconfigure your application.

[< README](../README.md) | [Credits >](../README.md#credits)
