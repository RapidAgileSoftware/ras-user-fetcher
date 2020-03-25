<?php

namespace Rasta\UserFetcher\Tests\Unit;

class ApiTest extends \Codeception\Test\Unit
{
    
    protected static $DefaultConfig = [
        'fetchUrl' => 'https://jsonplaceholder.typicode.com/users',
        'handler' => 'Rasta\UserFetcher\Handler',
        'caching' => 3600
    ];

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
        // if we construct new Instance without params, the default config should be used
        $this->assertEquals(self::$DefaultConfig['fetchUrl'], $this->instance->getFetchUrl());
        $this->assertEquals(self::$DefaultConfig['caching'], $this->instance->getCacheTime());
        $this->assertEquals(self::$DefaultConfig['handler'], $this->instance->getHandler());
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

    public function testErrorResponse()
    {
        $message = 'test message';
        $expected = json_encode(['Result' => 'Error', 'Message' => $message]);

        $this->assertEquals($expected, \Rasta\UserFetcher\Api::errorResponse($message));
    }

    public function testokResponse()
    {
        $data = ['any' => []];
        $expected = json_encode(['Result' => 'OK', 'Records' => $data]);

        $this->assertEquals($expected, \Rasta\UserFetcher\Api::okResponse($data));
    }
}
