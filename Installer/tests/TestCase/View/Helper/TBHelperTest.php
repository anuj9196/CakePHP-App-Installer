<?php
namespace Installer\Test\TestCase\View\Helper;

use Cake\TestSuite\TestCase;
use Cake\View\View;
use Installer\View\Helper\TBHelper;

/**
 * Installer\View\Helper\TBHelper Test Case
 */
class TBHelperTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \Installer\View\Helper\TBHelper
     */
    public $TB;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $view = new View();
        $this->TB = new TBHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TB);

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
