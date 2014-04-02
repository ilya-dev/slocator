If you are wondering, `Slocator` is short for `S`ervice `locator`. 

And that's what it is - Slocator is a Service Locator pattern implementation written in PHP `5.4+`.

+ "Catch" dynamic method calls
+ Retrieve an instance from the container
+ Perform a method call on it
+ Return the result

```php
$input  = $container->make('input');
$result = $input->foo('bar');
// against
$result = Input::foo('bar');
```
> Note that service locators are completely testable:
> Slocator leverages Mockery for that

Here is an overview of Slocator:

```php
// will be resolved from the container behind the scenes
Input::get('id');

Input::getBindingKey(); // => (string) "input"

Input::getInstance(); // => (object) Your\Input\Class

// think you cannot test it? you can!
// see https://github.com/padraic/mockery
Input::replaceWithMock();

Input::isMock(); // => (boolean) true

// declare expectations
Input::shouldReceive('get')->once()->with('id')->andReturn('134');

// back to "normal"?
Input::removeMock();
```

Want to switch the container?

```php
Input::setContainer(new Some\Class);

Input::getContainer(); // => (object) Some\Class
```

# API

+ `void replaceWithMock()`
+ `boolean isMock()`
+ `void removeMock()`
+ `mixed getInstance()`
+ `void setContainer(Slocator\Contracts\ContainerContract $container)`
+ `mixed getContainer()`
+ `string getBindingKey()`

# Getting started

## Create a service locator

Extend `Slocator\Slocator` and override `getBindingKey`:

```php
class Input extends Slocator\Slocator {
    
    public static function getBindingKey()
    {
        return 'input';
    }

}
```

Now bind the key above into the container:

```php
$container = new Slocator\Containers\LittleContainer;

$container->bind('input', new Your\Input\Class);
```

And pass the container:

```php
Input::setContainer($container);
```

That's it, you're done!

## Create your own container

Implement `Slocator\Contracts\ContainerContract` interface and you're all good to go!

Here's an example for `Little`:

```php
class LittleContainer extends \Little implements \Slocator\Contracts\ContainerContract {} 
```

As Little already implements `make($abstract)` method, I don't need to write any more code.

# License

Slocator is licensed under the MIT license. 
Check `LICENSE` file for more information.

## P.S.

Follow the author on Twitter [@ilya_s_dev](https://twitter.com/ilya_s_dev)

