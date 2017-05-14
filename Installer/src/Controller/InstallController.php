<?php
namespace Installer\Controller;

use Installer\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\File;

/**
* Install Controller
*
* @property \Installer\Model\Table\InstallTable $Install
*
* @method \Installer\Model\Entity\Install[] paginate($object = null, array $settings = [])
*/
class InstallController extends AppController
{
    /**
    * Default configuration
    *
    * @access	public
    * @return	void
    */
    public $DEFAULT_CONFIG = array(
        'className'  => 'Cake\Database\Connection',
        'driver'     => 'Cake\Database\Driver\Mysql',
        'persistent' => false,
        'host'       => 'localhost',
        'username'   => 'root',
        'password'   => 'root',
        'database'   => 'cakephp',
        'prefix'     => '',
        'encoding'   => 'UTF8',
    );

    /**
    * beforeFilter
    *
    * @access	public
    * @return	void
    */
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
    }

    /**
    * Check wheter the installation file already exists
    *
    * @access	public
    * @return	void
    */
    protected function _check(){
        if(Configure::read('Database.installed') == true) {
            $this->Flash->success(__("Website already configured"));
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
        $d['title_for_layout'] = __("Configuration test");
        $this->set($d);

        if($this->request->is('post')) {
            if($this->request->getData('create')) {
                $this->request->session()->write('Install.create', true);
                $this->redirect(array('action' => 'database'));
            } else {
                $this->request->session()->write('Install.create', false);
                $this->redirect(array('action' => 'connection'));
            }
        }
    }

	/**
	 * STEP 2 - DATABASE CREATION
	 *
	 * @access	public
	 * @return	void
	 */
	public function database() {
		$this->_check();
		$d['title_for_layout'] = __("Database creation");
		$this->set($d);
	}



	/**
	 * STEP 3 - DATABASE CONNECTION TEST
	 *
	 * @access	public
	 * @return	void
	 */
	public function connection() {
		$this->_check();
		$d['title_for_layout'] = __("Database connection");
		if (!file_exists(CONFIG.'app.default.php')) {
			rename(CONFIG.'app.default.php', CONFIG.'app.php');
		}

		if($this->request->is('post')) {

			// loads the default configuration
			$config = $this->DEFAULT_CONFIG;

			// loads form data
			$data = $this->request->getData();

			// replaces default config by form data
			foreach($data as $k => $v) {
				if(isset($data[$k])) {
					$config[$k] = $v;
				}
			}

			try {
				/**
			 	 * Try to connect the database with the new configuration
				 */
				ConnectionManager::config('my_default', $config);
				$db = ConnectionManager::get('my_default');
				if(!$db->connect()) {
					$this->Flash->error(__("Cannot connect to the database"));
				} else {
     				/**
     				 * We will create the true database.php file with our configuration
     				 */
                    $PLUGIN_CONFIG = ROOT.DS.'plugins'.DS.'Installer'.DS.'config'.DS;
     				copy($PLUGIN_CONFIG.'database.php.install', CONFIG.'my_database.php');
     				$file = new File(CONFIG. 'my_database.php');
     				$content = $file->read();
 					foreach($config as $k => $v) {
 						$content = str_replace('{default_' .$k.  '}', $v, $content);
 					}

					if($file->write($content)) {

                        // update bootstrap file
                        // bootstrap sting
                        $bootstrap_string = 'try\s{\s*Configure::config\(\'default\'\,\snew\sPhpConfig\(\)\)\;\s*Configure::load\(\'app\'\,\s\'default\'\,\sfalse\)\;\s*\}\scatch\s\(\\Exception\s\$e\)\s\{\s*exit\(\$e\-\>getMessage\(\)\s\.\s\"\\n\"\)\;\s*\}';
                        $bootstrap_old_script = '/'.$bootstrap_string.'/';
                        $bootstrap_replace_script = '/'.$bootstrap_string.'\n\nConfigure::load\(\'my_database\'\,\s\'default\'\)\;\n'.'/';

                        $bootstrap = new File(CONFIG.'bootstrap.php');
                        $bootstrap_content = $bootstrap->read();
                        $bootstrap_content2 = preg_replace($bootstrap_old_script, ' ', $bootstrap_content);
                        
                        if (!$bootstrap->write($bootstrap_content2)) {
                            $this->Flash->error(__('configuration could not be loaded to bootstrap.php file'));
                        }

						$this->Flash->success(__("Connected to the database"));
						$create = $this->request->session()->read('Install.create');
						if($create) {
					//		$this->redirect(array('action' => 'data'));
						} else {
					//		$this->redirect(array('action' => 'finish'));
						}
					} else {
						$this->Flash->error(__("my_database.php file cannot be modified"));
					}
				}
			} catch(Exception $e) {
				$this->Flash->error(__("Cannot connect to the database"));
			}
		} // post
		$this->set($d);
	} //function

    /**
 * STEP 4 - DATABASE CONSTRUCTION
 *
 * @access	public
 * @return	void
 */
public function data() {
    $this->_check();
    $d['title_for_layout'] = __("Database construction");

    if($this->request->is('post')) {

        $db = ConnectionManager::get('default');

        // connection to the database
        if(!$db->isConnect()) {
            $this->Flash->error(__("Cannot connect to the database"));
        } else {
            $sql_file = new File(CONFIG.'schema'.DS.'my_schema.sql');
            if (!$sql_file->exists()) {
                $this->Flash->error(__('Schema file does not exists. Make sure my_schema.sql exists in /config/schema/my_schema.sql'));
            } else {
                if (!$sql_file->size() > 0) {
                    $this->Flash->error(__('It seems schema file is empty. Please check if schema exits at /config/schema/my_schema.sql'));
                } else {
                    $sql_content = $sql_file->read();
                    // fetches all information of the tables of the Schema.php file (app/Config/Schema/Schema.php)
                    if ($db->execute($sql_content)) {
                        $this->Flash->success(__('Database imported'));
                    } else {
                        $this->Flash->error(__('Database Import Failed'));
                    }
                    $this->redirect(array('action' => 'finish'));
                }
            }
        }
    }

    $this->set($d);
} // function


	/**
	 * STEP 5 - INSTALLATION COMPLETE
	 *
	 * @access	public
	 * @return	void
	 */
	public function finish() {
		$this->_check();
		$d['title_for_layout'] = __("Installation complete");
        $PLUGIN_CONFIG = ROOT.DS.'plugins'.DS.'Installer'.DS.'config'.DS;
		$path = $PLUGIN_CONFIG.'bootstrap.php';
	//	if(!$this->_changeConfiguration('Database.installed', true, $path)){
	//		$this->Session->setFlash(__("Cannot modify Database.installed variable in app/Plugin/Install/Config/bootstrap.php"), 'Install.alert');
	//	}

		if($this->request->is('post')) {
			CakeSession::delete('Install.create');
			CakeSession::delete('Install.salt');
			CakeSession::delete('Install.seed');

			$this->redirect('/');
		}

		$this->set($d);
	}

    protected function _changeConfiguration($key, $value, $path = '') {
		/**
		 * we modify security key to be unique on each app
		 */
		if($path == '') $path = CONFIG.'core.php';

		App::uses('File', 'Utility');
		$file = new File($path);
		$contents = $file->read();
		$contents = preg_replace('/(?<=Configure::write\(\''.$key.'\', \')([^\' ]+)(?=\'\))/', $value, $contents);

		if($file->write($contents)) { return $value; }
		else { return false; }
	}
}
