<?php
declare(strict_types=1);

namespace CakePHPAppInstaller\Controller;

use Cake\Database\Exception\MissingConnectionException;
use Cake\Event\EventInterface;
use Exception;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Migrations\Migrations;
use SplFileObject;

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
     * @throws \Exception
     */
    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->loadComponent('Auth');
        $this->Auth->allow();
    }

    /**
     * STEP 1 - CONFIGURATION TEST
     *
     * @access    public
     * @return    void
     */
    public function index()
    {
        $this->_check();
        $d['title_for_layout'] = __('Configuration Check');
        $this->set($d);
    }

    /**
     * Check wheter the installation file already exists
     *
     * @access    public
     * @return    void
     */
    protected function _check()
    {
        if (Configure::read('Database.installed')) {
            $this->Flash->success(__('Website already configured'));
            // Removing redirect to allow user to re-configure application manually
//            $this->redirect('/');
        }
    }

    /**
     * STEP 2 - DATABASE CONNECTION TEST
     *
     * @access    public
     * @return    void
     * @throws \Exception
     */
    public function connection()
    {
        $this->_check();
        $d['title_for_layout'] = __('Database Connection Setup');

        if ($this->request->is('post')) {
            // Loads post form data
            $data = $this->request->getData();

            // Check if import_database is checked
            $import_database = $this->request->getData('import_database') || Configure::read('Installer.Import.migrations');

            // Replaces default config by form data
            foreach ($data as $k => $v) {
                if (isset($v)) {
                    Configure::write("Installer.Connection.$k", $v);
                }
            }

            // Add some extra bits and pieces that may be helpful
            // Generate salt and base url to add to app.php
            $salt = '';
            $salt_chars = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            for ($i = 0; $i < 40; ++$i) {
                $salt .= $salt_chars[random_int(0, strlen($salt_chars) - 1)];
            }
            Configure::write('Installer.Connection.salt', $salt);

            /**
             * TODO: Replacement for full base url is still to be configured based on user's choice, help needed
             */
            $request_scheme = isset($_SERVER['HTTPS']) ? 'https' : 'http';
            Configure::write('Installer.Connection.baseurl', "$request_scheme://{$_SERVER['HTTP_HOST']}");

            try {
                /**
                 * Try to connect the database with the new configuration
                 */
                ConnectionManager::setConfig('my_default', Configure::read('Installer.Connection'));
                $db = ConnectionManager::get('my_default');
                $db->connect();

                /**
                 * We will create the true database configuration file with our configuration
                 */
                $success = true;
                $written = [];

                foreach (Configure::read('Installer.Files') as $config) {
                    /**
                     * Each $config have data in following format
                     * [
                     *     'use' => true|false,                    # whether true or false, use only if true
                     *     'filename' => app.php,                  # new file name to save with inside config directory
                     *     'default' => '/path/to/default/file'    # default file to read content from
                     * ]
                     *
                     */
                    if ($config['use'] && file_exists($config['default'])) {

                        /**
                         * If change_salt is not checked, skip modifying app.php file
                         */
                        if ((!array_key_exists('change_salt', $data) || !$data['change_salt']) && $config['filename'] === 'app.php') {
                            continue;
                        }

                        // Read default file content
                        $content = file_get_contents($config['default']);

                        /**
                         * Replace database configurations
                         * This will generate new configuration file database.php with contents from
                         * database.php.install from plugin config path
                         */
                        foreach (Configure::read('Installer.Connection') as $k => $v) {
                            $content = str_replace('{default_' . $k . '}', $v, $content);
                        }

                        /**
                         * Replace SALT if possible
                         * This will replace __SALT__ from app.default.php to new app.php
                         */
                        if (array_key_exists('change_salt', $data) && $data['change_salt']) {
                            $content = str_replace('__SALT__', Configure::read('Installer.Connection.salt'), $content);

                            $this->Flash->success('Salt Value changed');
                        }

                        /**
                         * Output file object
                         */
                        $output = CONFIG . $config['filename'];

                        /**
                         * Write output file content to new file
                         */
                        if (file_put_contents($output, $content)) {
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

                    // Import database if import_database is checked
                    if ($import_database) {
                        $this->redirect(['action' => 'data']);
                    } else {
                        $this->redirect(['action' => 'finish']);
                    }
                } else {
                    // Remove any config files that were written successfully, so that we try them again next time.
                    foreach ($written as $file) {
                        unlink($file);
                    }
                }
            } catch (MissingConnectionException $e) {
                $this->Flash->error($e->getMessage());
            } catch (Exception $e) {
                $this->Flash->error(__('Cannot connect to the database: {0}', $e->getMessage()));
            }
        } // Post
        $this->set($d);
    } // Function

    /**
     * STEP 3 - DATABASE CONSTRUCTION
     *
     * @access    public
     * @return    void
     */
    public function data()
    {
        $this->_check();
        $d['title_for_layout'] = __('Database Construction');

        $db = ConnectionManager::get('default');

        // connection to the database
        try {
            $db->connect();
            $this->set(['database_connect' => true]);

            if ($this->request->is('post') && $this->_importSchema($db) && $this->_handleMigrations()) {
                $this->Flash->success(__('Database imported'));
                $this->redirect(['action' => 'finish']);
            }
        } catch (Exception $connectionError) {
            $this->set(['database_connect' => false]);
            $this->Flash->error(__('Can not connect to database: {0}', $connectionError->getMessage()));
        }

        $this->set($d);
    } // function

    /**
     * @access    protected
     * @return    bool
     */
    protected function _importSchema($db)
    {
        $schema = Configure::read('Installer.Import.schema');
        if (!$schema) {
            return true;
        }

        $sql_file = new SplFileObject(CONFIG . $schema);
        if (!$sql_file->isFile()) {
            $this->Flash->error(__('Schema file does not exists. Make sure /config{0} exists.', $schema));

            return false;
        }

        $file_size = $sql_file->getSize();
        if ($file_size === false || $file_size <= 0) {
            $this->Flash->error(__('It seems schema file is empty. Please check if schema exists at /config{0}', $schema));

            return false;
        }

        // fetches all information of the tables of the schema file
        $sql_content = $sql_file->fread($file_size);
        // TODO: Perhaps support Cake's schema-dump-default.lock JSON format?
        if (!$db->execute($sql_content)) {
            $this->Flash->error(__('Database Import Failed'));

            return false;
        }

        return true;
    }

    /**
     * @access    protected
     * @return    bool
     */
    protected function _handleMigrations()
    {
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
        } catch (Exception $ex) {
            $this->Flash->error(__('Database Import Failed: {0}', $ex->getMessage()));

            return false;
        }

        return true;
    }

    /**
     * STEP 4 - INSTALLATION COMPLETE
     *
     * @access    public
     * @return    void
     */
    public function finish()
    {
        $this->_check();
        $d['title_for_layout'] = __('Installation Complete');

        if (!$this->_changeConfiguration()) {
            $this->Flash->error(__('Cannot modify Database.installed variable in {0}bootstrap.php; you must manually update this to true to prevent a later install from overwriting your configuration!', PLUGIN_CONFIG));
        }

        $this->set($d);
    }

    /**
     * change Database.Installed to true
     */
    protected function _changeConfiguration()
    {
        $path = PLUGIN_CONFIG . 'bootstrap.php';

        $file = file_get_contents($path);
        $content_new = str_replace('false', 'true', $file);

        return file_put_contents($path, $content_new);
    }
}
