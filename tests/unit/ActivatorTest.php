<?php

namespace Rasta\UserFetcher\Tests\Unit;

class ActivatorTest extends \Codeception\Test\Unit
{

    protected static $DefaultConfig = [
        'endpoint' => 'ras-user-fetcher',
        'handler' => 'Rasta\UserFetcher\Handler',
        'page_title' => 'Users Table',
        'snippet' => '<div id="ras-user-fetcher-details" /><div id="ras-user-fetcher" />'
    ];

    /**
     * @var \Rasta\UserFetcher\Activator
     */
    protected $instance;



    public function __construct()
    {
        parent::__construct();
        $this->instance = new \Rasta\UserFetcher\Activator();
    }

    protected function _before()
    {
   // set fresh instance before each test
        $this->instance = new \Rasta\UserFetcher\Activator();
    }

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

    public function testCustomConstruction()
    {
        // define a custom config for Activator
        $config = [
            'endpoint'   => 'custom-endpoint',
            'handler'    => 'Rasta\UserFetcher\Tests\Unit\Handler',
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

    public function testGetterAndSetterForEndpoint()
    {
        // lets set and get a custom endpoint
        $custom_endpoint = 'get-set-endpoint';
        $this->assertEquals($custom_endpoint, $this->instance->setEndpoint($custom_endpoint)->getEndpoint());
        // endpoint should be nullable, we fall back to default via getter
        $default = self::$DefaultConfig['endpoint'];
        $this->assertEquals($default, $this->instance->setEndpoint(null)->getEndpoint());
    }

    public function testGetterAndSetterForHandler()
    {
        // lets set and get a custom endpoint
        $test_handler = 'Rasta\UserFetcher\Tests\Unit\TestHandler';
        $this->assertEquals($test_handler, $this->instance->setHandler($test_handler)->getHandler());
        // handler should be nullable, we fall back to default via getter
        $default = self::$DefaultConfig['handler'];
        $this->assertEquals($default, $this->instance->setHandler(null)->getHandler());
    }

    public function testGetterAndSetterForPageTitle()
    {
        // lets set and get a custom endpoint
        $test_title = 'Test Page Title';
        $this->assertEquals($test_title, $this->instance->setPageTitle($test_title)->getPageTitle());
        // handler should be nullable, we fall back to default via getter
        $default = self::$DefaultConfig['page_title'];
        $this->assertEquals($default, $this->instance->setPageTitle(null)->getPageTitle());
    }

    public function testGetterAndSetterForSnippet()
    {
        // lets set and get a custom endpoint
        $test_snippet = '<b>SnipSnap</b>';
        $this->assertEquals($test_snippet, $this->instance->setSnippet($test_snippet)->getSnippet());
        // handler should be nullable, we fall back to default via getter
        $default = self::$DefaultConfig['snippet'];
        $this->assertEquals($default, $this->instance->setSnippet(null)->getSnippet());
    }
}
