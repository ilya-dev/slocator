<?php namespace Slocator;

use Slocator\Contracts\ContainerContract;
use Mockery, Mockery\MockInterface;

abstract class Slocator {

    /**
     * The container instance
     *
     * @var Slocator\Contracts\ContainerContract
     */
    protected static $container;

    /**
     * Mocked instances
     *
     * @var array
     */
    protected static $mocks = [];

    /**
     * Resolve the underlying class instance
     *
     * @return mixed
     */
    public static function getInstance()
    {
        $key = static::getBindingKey();

        if (isset(static::$mocks[$key]))
        {
            return static::$mocks[$key];
        }

        return static::$container->make($key);
    }

    /**
     * Get the binding key
     *
     * @throws BadMethodCallException
     * @return string
     */
    public static function getBindingKey()
    {
        throw new \BadMethodCallException('You should override this method');
    }

    /**
     * Replace the underlying instance with a mock object
     *
     * @return void
     */
    public static function replaceWithMock()
    {
        $class = get_class(static::getInstance());

        static::$mocks[static::getBindingKey()] = Mockery::mock($class);
    }

    /**
     * Determine whether the underlying instance is a mock
     *
     * @return boolean
     */
    public static function isMock()
    {
        return static::getInstance() instanceof MockInterface;
    }

    /**
     * Replace the mock object with the original instance
     *
     * @return void
     */
    public static function removeMock()
    {
        unset(static::$mocks[static::getBindingKey()]);
    }

    /**
     * Set the container instance
     *
     * @param  Slocator\Contracts\ContainerContract $container
     * @return void
     */
    public static function setContainer(ContainerContract $container)
    {
        static::$container = $container;
    }

    /**
     * Get the container instance
     *
     * @return Slocator\Contracts\ContainerContract
     */
    public static function getContainer()
    {
        return static::$container;
    }

    /**
     * Handle dynamic method calls
     *
     * @param  string $method
     * @param  array  $arguments
     * @return mixed
     */
    public static function __callStatic($method, array $arguments)
    {
        $callable = [static::getInstance(), $method];

        return call_user_func_array($callable, $arguments);
    }

}

