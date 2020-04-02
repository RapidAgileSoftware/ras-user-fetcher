<?php

namespace Rasta\UserFetcher\Tests;

class ActivatorTest extends \Codeception\Test\Unit
{
    /**
     * holds the current default configuration
     * @var array
     */
    protected static $DefaultConfig = [
        'endpoint' => 'ras-user-fetcher',
        'handler' => 'Rasta\UserFetcher\Handler',
        'page_title' => 'Users Table',
        'snippet' => '<div id="ras-user-fetcher-details"></div><div id="ras-user-fetcher"></div>'
    ];

    /**
     * eases access to tested class
     * @var \Rasta\UserFetcher\Api
     */
    protected $instance;

    /**
     * Reference to the mocked dependency handler
     * @var string
     */
    public $mockedHandler = 'Rasta\UserFetcher\Tests\MockHandler';


    /**
     * sets instance property to Activator class
     */
    public function __construct()
    {
        parent::__construct();
        $this->instance = new \Rasta\UserFetcher\Activator();
    }
    /**
     * reset $this->instance to default state before each test function
     */
    protected function _before()
    {
        // set fresh instance before each test
        $this->instance = new \Rasta\UserFetcher\Activator();
    }
    /**
     * shorthand to use mocked dependencies rather the standard
     * @return [type] [description]
     */
    protected function activateMock()
    {
        $this->instance->setHandler($this->mockedHandler);
    }
    /**
     * test the default construction
     */
    public function testDefaultConstruction()
    {
        // retrieve the DefaultConfig
        $DefaultConfig = self::$DefaultConfig;
        // if we construct new Instance without params, the default config should be used
        $this->assertEquals($DefaultConfig['endpoint'], $this->instance->getEndpoint());
        $this->assertEquals($DefaultConfig['handler'], $this->instance->getHandler());
        $this->assertEquals($DefaultConfig['page_title'], $this->instance->getPageTitle());
        $this->assertEquals($DefaultConfig['snippet'], $this->instance->getSnippet());
    }
    /**
     * tests the custom construction
     */
    public function testCustomConstruction()
    {
        // define a custom config for Activator
        $config = [
            'endpoint'   => 'custom-endpoint',
            'handler'    => $this->mockedHandler,
            'page_title' => 'Custom Page Title',
            'snippet'    => 'Random snippet'
        ];
        // new instance with
        $this->instance = new \Rasta\UserFetcher\Activator(
            $config['endpoint'],
            $config['page_title'],
            $config['snippet'],
            $config['handler']
        );
        // now we check if our custom parameters are all set
        $this->assertEquals($config['endpoint'], $this->instance->getEndpoint());
        $this->assertEquals($config['handler'], $this->instance->getHandler());
        $this->assertEquals($config['page_title'], $this->instance->getPageTitle());
        $this->assertEquals($config['snippet'], $this->instance->getSnippet());
    }
    /**
     * tests the getter and setter for endpoint property
     */
    public function testGetterAndSetterForEndpoint()
    {
        // lets set and get a custom endpoint
        $custom_endpoint = 'get-set-endpoint';
        $this->assertEquals($custom_endpoint, $this->instance->setEndpoint($custom_endpoint)->getEndpoint());
        // endpoint should be nullable, we fall back to default via getter
        $default = self::$DefaultConfig['endpoint'];
        $this->assertEquals($default, $this->instance->setEndpoint(null)->getEndpoint());
    }
    /**
     * tests the getter and setter for handler property
     */
    public function testGetterAndSetterForHandler()
    {
        // lets set and get a custom endpoint
        $handler = $this->mockedHandler;
        $this->assertEquals($handler, $this->instance->setHandler($handler)->getHandler());
        // handler should be nullable, we fall back to default via getter
        $default = self::$DefaultConfig['handler'];
        $this->assertEquals($default, $this->instance->setHandler(null)->getHandler());
    }
    /**
     * tests the getter and setter for page title property
     */
    public function testGetterAndSetterForPageTitle()
    {
        // lets set and get a custom endpoint
        $test_title = 'Test Page Title';
        $this->assertEquals($test_title, $this->instance->setPageTitle($test_title)->getPageTitle());
        // handler should be nullable, we fall back to default via getter
        $default = self::$DefaultConfig['page_title'];
        $this->assertEquals($default, $this->instance->setPageTitle(null)->getPageTitle());
    }
    /**
     * tests the getter and setter for snippet property
     */
    public function testGetterAndSetterForSnippet()
    {
        // lets set and get a custom endpoint
        $test_snippet = '<b>SnipSnap</b>';
        $this->assertEquals($test_snippet, $this->instance->setSnippet($test_snippet)->getSnippet());
        // handler should be nullable, we fall back to default via getter
        $default = self::$DefaultConfig['snippet'];
        $this->assertEquals($default, $this->instance->setSnippet(null)->getSnippet());
    }
    /**
     * tests the getter and setter for page property
     */
    public function testGetterAndSetterForPage()
    {
        $this->activateMock();
        // lets set a custom page array
        $custom_page = ['id' => 666, 'title' => 'my title', 'body' => 'my body text'];
        //lets try the normal getter/setter functionality
        $this->assertEquals($custom_page, $this->instance->setPage($custom_page)->getPage());

        $mocked_response = [
                'ID' => 1,
                'post_title'  => 'Valid Post Title',
                'post_name'   => 'valid-path',
                'post_content' => '<span id="something" />',
                'post_status' => 'publish',
                'post_type'   => 'page'
            ];
        // we need to bust cached page first, we set a new endpoint for doing that
        $this->assertEquals($mocked_response, $this->instance->setEndpoint('valid-path')->getPage());
        // getPage should return false if the endpoint path is invalid
        $this->assertFalse($this->instance->setEndpoint('invalid-path')->getPage());
    }
    /**
     * test if double activation is prevented
     */
    public function testDoubleActivation()
    {
        $this->activateMock();
        // we activate it for the first time, we expect TRUE as success
        $this->assertTrue($this->instance->activate());
        // if we try that again a couple of times, since the page already exists, we'll expect always FALSE
        for ($x = 0; $x <= 100; $x++) {
            $this->assertFalse($this->instance->activate());
        }
    }

    /**
     * try to acyivate a invalid endpoint rejected by wp
     */
    public function testInvalidEndpointActivation()
    {
        // test when wp refuse to create new page,
        $this->activateMock();
        // here: invalid-post-path is refused by the handler
        $this->assertFalse($this->instance->setEndpoint('invalid-post-path')->activate());
    }

    /**
     * test if double deactivation is prevented
     */
    public function testDoubleDeactivation()
    {
        $this->activateMock();
        // We activate it, then we deactivate it
        $this->instance->activate();
        // should return TRUE
        $this->assertTrue($this->instance->deactivate());
        // try it again multiple times, should be false every time
        for ($x = 0; $x <= 100; $x++) {
            $this->assertFalse($this->instance->deactivate());
        }
    }
    /**
     * test deactivate without activation
     */
    public function testInvalidDeactivation()
    {
        $this->activateMock();
        // deactivate without activate should be False
        $this->assertFalse($this->instance->deactivate());
    }
    /**
     * test getter and setter for property js_dependencies
     * @return [type] [description]
     */
    public function testGetJSDependencies()
    {
        $default = [
            ['handle' => 'rasta-user-fetcher-ui', 'src' => '../public/js/jquery-ui.min.js'],
            ['handle' => 'rasta-user-fetcher-jtable', 'src' => '../public/js/jquery.jtable.min.js'],
            ['handle' => 'rasta-user-fetcher-core', 'src' => '../public/js/rasta-user-fetcher.min.js']
        ];
        // test for the default
        $this->assertEquals($default, $this->instance->getJSDependencies());
        //now set custom set of dependencies
        $this->instance->js_dependendies = [];
        $this->assertEquals([], $this->instance->getJSDependencies());
        $custom = [ ['handle' => 'new-handle', 'src' => '../public/js/any.js'] ];
        $this->instance->js_dependendies = $custom;
        $this->assertEquals($custom, $this->instance->getJSDependencies());
    }

    /**
     * try to load scripts for valid/ invalid paths
     */
    public function testLoadScripts()
    {
        $this->activateMock();
        $valid = 'valid-path';
        $invalid = 'invalid-path';
        // in a valid endpoint we get true
        $this->assertTrue($this->instance->setEndpoint($valid)->loadScripts());
        // otherwise false
        $this->assertFalse($this->instance->setEndpoint($invalid)->loadScripts());
    }
}
