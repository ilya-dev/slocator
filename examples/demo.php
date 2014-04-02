<?php require __DIR__.'/../vendor/autoload.php';

class Foo extends Slocator\Slocator {

    public static function getBindingKey()
    {
        return 'foo';
    }

    public function bar()
    {
        return 'baz';
    }

}

class Bar extends Slocator\Slocator {

    public static function getBindingKey()
    {
        return 'bar';
    }

    public function foo()
    {
        return 'baz';
    }

}

$container = new Slocator\Containers\LittleContainer;

$container->bind('foo', 'Foo');
$container->bind('bar', 'Bar');

Foo::setContainer($container);
Bar::setContainer($container);

// the demo is working properly as long as the result is equal to TRUE
var_dump(Foo::bar() === Bar::foo());

