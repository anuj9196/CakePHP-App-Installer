<?php
declare(strict_types=1);

namespace CakePHPAppInstaller\Controller\Component;

use Cake\Controller\Component;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;

/**
 * Install component
 *
 * @property \Cake\Controller\Component\FlashComponent $Flash
 */
class InstallComponent extends Component
{
    public $components = ['Flash'];

    public function installationCheck()
    {
        // check for installation of database configuration

        // first check for database connection using default
        // connection to the database
        try {
            $connection = ConnectionManager::get('default');
            $connection->connect();
        } catch (\Exception $connectionError) {
            if (Configure::read('Database.installed')) {
                // if database connection not established
                // and Database.installed is set to TRUE
                // this could be the cause that either database settings are modified
                // or database server has been modified
                // or username or password of database has been reset
                $this->Flash->error(__('Database connection couldn\'t be established. It seems your database configuration has been modified. Please, re-configure it to start the application.'));

                // reset Database.installed to false
                if (!$this->_changeConfiguration()){
                    $this->Flash->error(__('Cannot modify Database.installed variable in {0}bootstrap.php; you must manually update this to true to prevent a later install from overwriting your configuration!', PLUGIN_CONFIG));
                }
            } else {
                // if database connection not established
                // and Database.installed is not TRUE
                // this could be the cause that Database configuration has not been made yet
                // ask user to set up database configuration
                $this->Flash->error(__('Please configure your database settings for working of your application'));
            }

            return $this->_registry->getController()->redirect(['plugin' => 'CakePHPAppInstaller', 'controller' => 'Install', 'action' => 'index']);
        }

        return true;
    }

    /**
    * change Database.Installed to true
    */
    protected function _changeConfiguration() {
        $path = PLUGIN_CONFIG.'bootstrap.php';

        $file = file_get_contents($path);
        $content_new = str_replace('true', 'false', $file);

        return file_put_contents($content_new, $content_new);
    }
}
