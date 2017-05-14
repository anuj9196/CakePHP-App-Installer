<?php
namespace Installer\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use Installer\View\Helper\AppHelper;

/**
 * Installer\View\Helper\AppHelper Test Case
 */
class AppHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Installer\View\Helper\AppHelper
     */
    public $App;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->App = new AppHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->App);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
