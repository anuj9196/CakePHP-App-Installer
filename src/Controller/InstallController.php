<?php
namespace Installer\Controller;

use Cake\Database\Exception\MissingConnectionException;
use Exception;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\File;
use Migrations\Migrations;

/**
* Install Controller
*/
class InstallController extends AppController
{
    /**
     * beforeFilter
     *
     * @access public
     * @param Event $event
     * @return void
     */
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->loadComponent('Auth');
        $this->Auth->allow();
    }

    /**
    * Check wheter the installation file already exists
    *
    * @access	public
    * @return	void
    */
    protected function _check(){
        if (Configure::read('Database.installed') == true) {
            $this->Flash->success(__('Website already configured'));
            $this->redirect('/');
        }
    }


    /**
    * STEP 1 - CONFIGURATION TEST
    *
    * @access	public
    * @return	void
    */
    public function index() {
        $this->_check();
        $d['title_for_layout'] = __('Configuration Check');
        $this->set($d);
    }

    /**
    * STEP 2 - DATABASE CONNECTION TEST
    *
    * @access	public
    * @return	void
    */
    public function connection() {
        $this->_check();
        $d['title_for_layout'] = __('Database Connection Setup');

        if ($this->request->is('post')) {
            // loads form data
            $data = $this->request->data();

            // check if import_database is checked
            $import_database = $this->request->data('import_database') || Configure::read('Installer.Import.migrations');

            // replaces default config by form data
            foreach ($data as $k => $v) {
                if (isset($data[$k])) {
                    Configure::write("Installer.Connection.$k", $v);
                }
            }

            // add some extra bits and pieces that may be helpful
            $salt = '';
            $salt_chars = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            for ($i = 0; $i < 40; ++ $i) {
                $salt .= $salt_chars[mt_rand(0, strlen($salt_chars) - 1)];
            }
            Configure::write('Installer.Connection.salt', $salt);
            Configure::write('Installer.Connection.baseurl', "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}");

            try {
                /**
                 * Try to connect the database with the new configuration
                 */
                ConnectionManager::config('my_default', Configure::read('Installer.Connection'));
                $db = ConnectionManager::get('my_default');
                $db->connect();

                /**
                 * We will create the true database configuration file with our configuration
                 */
                $success = true;
                $written = [];
                foreach (Configure::read('Installer.Files') as $key => $config) {
                    if ($config['use'] && !file_exists(CONFIG . $config['filename'])) {
                        $input = new File($config['default']);
                        $content = $input->read();
                        foreach (Configure::read('Installer.Connection') as $k => $v) {
                            $content = str_replace('{default_' . $k . '}', $v, $content);
                        }

                        $output = new File(CONFIG . $config['filename']);
                        if ($output->write($content)) {
                            $written[] = $output;
                        } else {
                            $this->Flash->error(__('{0} file cannot be modified', $config['filename']));
                            $success = false;
                            break;
                        }
                    }
                }

                if ($success) {
                    $this->Flash->success(__('Connected to the database'));

                    // import database if import_database is checked
                    if ($import_database) {
                        $this->redirect(['action' => 'data']);
                    } else {
                        $this->redirect(['action' => 'finish']);
                    }
                } else {
                    // Remove any config files that were written successfully, so that we try them again next time.
                    foreach ($written as $file) {
                        $file->delete();
                    }
                }
            } catch (MissingConnectionException $e) {
                $this->Flash->error($e->getMessage());
            } catch(Exception $e) {
                $this->Flash->error(__('Cannot connect to the database: {0}', $e->getMessage()));
            }
        } // post
        $this->set($d);
    } //function

    /**
    * STEP 3 - DATABASE CONSTRUCTION
    *
    * @access	public
    * @return	void
    */
    public function data() {
        $this->_check();
        $d['title_for_layout'] = __('Database Construction');

        $db = ConnectionManager::get('default');

        // connection to the database
        try {
            $db->connect();
            $this->set(['database_connect' => true]);

            if ($this->request->is('post') && $this->_importSchema($db) && $this->_handleMigrations()) {
                $this->Flash->success(__('Database imported'));
                $this->redirect(array('action' => 'finish'));
            }
        } catch (Exception $connectionError) {
            $this->set(['database_connect' => false]);
            $this->Flash->error(__('Can not connect to database: {0}', $connectionError->getMessage()));
        }

        $this->set($d);
    } // function

    /**
    * STEP 4 - INSTALLATION COMPLETE
    *
    * @access	public
    * @return	void
    */
    public function finish() {
        $this->_check();
        $d['title_for_layout'] = __('Installation Complete');

        if (!$this->_changeConfiguration()){
            $this->Flash->error(__('Cannot modify Database.installed variable in /plugins/Installer/config/bootstrap.php; you must manually update this to true to prevent a later install from overwriting your configuration!'));
        }

        $this->set($d);
    }

    /**
    * change Database.Installed to true
    */
    protected function _changeConfiguration() {
        $path = PLUGIN_CONFIG.'bootstrap.php';

        $file = new File($path);
        $contents = $file->read();
        $content_new = str_replace('false', 'true', $contents);
        if ($file->write($content_new)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @access	protected
     * @return	bool
     */
    protected function _importSchema($db) {
        $schema = Configure::read('Installer.Import.schema');
        if (!$schema) {
            return true;
        }

        $sql_file = new File(CONFIG . $schema);
        if (!$sql_file->exists()) {
            $this->Flash->error(__('Schema file does not exists. Make sure /config{0} exists.', $schema));
            return false;
        }

        if (!$sql_file->size() > 0) {
            $this->Flash->error(__('It seems schema file is empty. Please check if schema exists at /config{0}', $schema));
            return false;
        }

        // fetches all information of the tables of the schema file
        $sql_content = $sql_file->read();
        // TODO: Perhaps support Cake's schema-dump-default.lock JSON format?
        if (!$db->execute($sql_content)) {
            $this->Flash->error(__('Database Import Failed'));
            return false;
        }

        return true;
    }

    /**
     * @access	protected
     * @return	bool
     */
    protected function _handleMigrations() {
        if (!Configure::read('Installer.Import.migrations')) {
            return true;
        }

        try {
            $migrations = new Migrations(['connection' => 'default']);

            // Check if there is a pre-migrate callback
            $pre_migrate = Configure::read('Installer.Import.pre_migrate');
            if ($pre_migrate) {
                $pre_migrate($this, $migrations);
            }

            $migrations->migrate();

            // Check if there is a post-migrate callback
            $post_migrate = Configure::read('Installer.Import.post_migrate');
            if ($post_migrate) {
                $post_migrate($this, $migrations);
            }
        } catch (\Exception $ex) {
            $this->Flash->error(__('Database Import Failed: {0}', $ex->getMessage()));
            return false;
        }

        return true;
    }
}
