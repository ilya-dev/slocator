<?php

class LocatorTest extends PHPUnit_Framework_TestCase {

    /**
     * This method gets fired after each test runs
     *
     * @return void
     */
    protected function tearDown()
    {
        Mockery::close();

        Locator::removeMock();
    }

    /**
     * @test
     */
    function it_allows_you_to_manipulate_the_container_instance()
    {
        $container = Mockery::mock('Slocator\Contracts\ContainerContract');

        Locator::setContainer($container);

        $this->assertEquals($container, Locator::getContainer());
    }

    /**
     * @test
     */
    function it_allows_you_to_fetch_the_binding_key()
    {
        $this->assertEquals('locator', Locator::getBindingKey());
    }

    /**
     * @test
     */
    function it_allows_you_to_fetch_the_underlying_instance()
    {
        $container = Mockery::mock('Slocator\Contracts\ContainerContract');

        $container->shouldReceive('make')
                  ->once()->with('locator')->andReturn('foobar');

        Locator::setContainer($container);

        $this->assertEquals(Locator::getInstance(), 'foobar');
    }

    /**
     * @test
     */
    function it_allows_you_to_determine_whether_the_underlying_instance_is_a_mock()
    {
        $container = Mockery::mock('Slocator\Contracts\ContainerContract');

        $container->shouldReceive('make')
            ->twice()->andReturn(null, Mockery::self());

        Locator::setContainer($container);

        $this->assertFalse(Locator::isMock());

        $this->assertTrue(Locator::isMock());
    }

    /**
     * @test
     */
    function it_allows_you_to_replace_the_underlying_instance_with_a_mock()
    {
        $container = Mockery::mock('Slocator\Contracts\ContainerContract');

        $container->shouldReceive('make')
            ->twice()->andReturn(null, new stdClass);

        Locator::setContainer($container);

        $this->assertFalse(Locator::isMock());

        Locator::replaceWithMock();

        $this->assertTrue(Locator::isMock());
    }

    /**
     * @test
     */
    function it_handles_dynamic_method_calls()
    {
        $container = Mockery::mock('Slocator\Contracts\ContainerContract');
        $instance  = Mockery::mock();

        $instance->shouldReceive('foo')
            ->once()->with('bar')->andReturn('baz');

        $container->shouldReceive('make')
            ->once()->andReturn($instance);

        Locator::setContainer($container);

        $this->assertEquals('baz', Locator::foo('bar'));
    }

}

class Locator extends Slocator\Slocator {

    /**
     * Get the binding key
     *
     * @return string
     */
    public static function getBindingKey()
    {
        return 'locator';
    }

}

