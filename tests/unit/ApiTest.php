<?php

namespace Rasta\UserFetcher\Tests;

class ApiTest extends \Codeception\Test\Unit
{
    /**
     * holds the current default configuration
     * @var array
     */
    protected static $DefaultConfig = [
        'fetchUrl' => 'https://jsonplaceholder.typicode.com/users',
        'handler' => 'Rasta\UserFetcher\Handler',
        'caching' => 3600
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
     * sets instance property to Api class
     */
    public function __construct()
    {
        parent::__construct();
        $this->instance = new \Rasta\UserFetcher\Api();
    }
    /**
     * reset $this->instance to default state before each test function
     */
    protected function _before()
    {
        // set fresh instance before each test
        $this->instance = new \Rasta\UserFetcher\Api();
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
        // if we construct new Instance without params, the default config should be used
        $this->assertEquals(self::$DefaultConfig['fetchUrl'], $this->instance->getFetchUrl());
        $this->assertEquals(self::$DefaultConfig['caching'], $this->instance->getCacheTime());
        $this->assertEquals(self::$DefaultConfig['handler'], $this->instance->getHandler());
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
     * tests the error response output
     */
    public function testErrorResponse()
    {
        $message = 'test message';
        $expected = json_encode(['Result' => 'Error', 'Message' => $message]);

        $this->assertEquals($expected, \Rasta\UserFetcher\Api::errorResponse($message));
    }
    /**
     * tests the ok response output
     */
    public function testOkResponse()
    {
        $data = ['any' => []];
        $expected = json_encode(['Result' => 'OK', 'Records' => $data]);

        $this->assertEquals($expected, \Rasta\UserFetcher\Api::okResponse($data));
    }
}
