<?php

namespace Rasta\UserFetcher\Tests\Unit;

class ApiTest extends \Codeception\Test\Unit
{
    /**
     * @var \Rasta\UserFetcher\Api
     */
    protected $instance;

    /**
    * Reference to the mocked dependency handler
    **/
    public $mockedHandler = 'Rasta\UserFetcher\Tests\Unit\MockHandler';

    public function __construct()
    {
        parent::__construct();
        $this->instance = new \Rasta\UserFetcher\Api();
    }

    protected function _before()
    {
        // set fresh instance before each test
        $this->instance = new \Rasta\UserFetcher\Api();
    }

    protected function activateMock()
    {
        $this->instance->setHandler($this->mockedHandler);
    }

    public function testDefaultConstruction()
    {
        $default = 'https://jsonplaceholder.typicode.com/users';
        // if we construct new Instance without params, the default config should be used
        $this->assertEquals($default, $this->instance->fetchUrl);
    }

    public function testGetterAndSetterForHandler()
    {
        // lets set and get a custom endpoint
        $handler = $this->mockedHandler;
        $this->assertEquals($handler, $this->instance->setHandler($handler)->getHandler());
        // handler should be nullable, we fall back to default via getter
        $default = self::$DefaultConfig['handler'];
        $this->assertEquals($default, $this->instance->setHandler(null)->getHandler());
    }
}