<?php
namespace Installer\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
use Cake\Filesystem\File;

/**
 * Install component
 */
class InstallComponent extends Component
{
    public $components = ['Flash'];

    public function installationCheck()
    {
        // check for installation of database configuration

        // first check for database connection using default connection
        // connection to the database
        try {
            $connection = ConnectionManager::get('default');
            $connection->connect();
        } catch (\Exception $connectionError) {
            if (Configure::read('Database.installed') == true) {
                // if database connection not established
                // and Database.installed is set to TRUE
                // this could be the cause that either database settings are modified
                // or database server has been modified
                // or username or password of database has been reset
                $this->Flash->error(__('Database connection couldn\'t be established. It seems your database configuration has been modified. Please, re-configure it to start the application.'));

                // reset Database.installed to false
                if (!$this->_changeConfiguration()){
                    $this->Flash->error(__('Cannot modify Database.installed variable in /plugins/Installer/config/bootstrap.php; you must manually update this to true to prevent a later install from overwriting your configuration!'));
                }
                return $this->_registry->getController()->redirect(['plugin' => 'Installer', 'controller' => 'Install', 'action' => 'index']);
            } else {
                // if database connection not established
                // and Database.installed is not TRUE
                // this could be the cause that Database configuration has not been made yet
                // ask user to setup database configuration
                $this->Flash->error(__('Please configure your database settings for working of your application'));
                return $this->_registry->getController()->redirect(['plugin' => 'Installer', 'controller' => 'Install', 'action' => 'index']);
            }
        }

        return true;
    }

    /**
    * change Database.Installed to true
    */
    protected function _changeConfiguration() {
        $path = PLUGIN_CONFIG.'bootstrap.php';

        $file = new File($path);
        $contents = $file->read();
        $content_new = str_replace('true', 'false', $contents);
        if ($file->write($content_new)) {
            return true;
        } else {
            return false;
        }
    }
}
