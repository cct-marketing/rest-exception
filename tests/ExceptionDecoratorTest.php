<?php

declare(strict_types=1);

namespace CCT\Component\RestExceptionHandler\Tests;

use CCT\Component\RestExceptionHandler\ExceptionDecorator;
use CCT\Component\RestExceptionHandler\Exception\InvalidExceptionHandlerException;
use CCT\Component\RestExceptionHandler\Tests\Faker\FakeObject;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class ExceptionDecoratorTest extends TestCase
{
    public function testInstanceOfWidthRequestObjectReturnsTrue()
    {
        $testObject = new FakeObject();
        $object = new ExceptionDecorator($testObject);
        $this->assertTrue($object->instanceOf(FakeObject::class));
    }

    public function testCallMethodShouldReturnsCorrectValue()
    {
        $testObject = new FakeObject();
        $testObject->setName('Bob');
        $object = new ExceptionDecorator($testObject);
        $this->assertEquals('Bob', $object->getName());
    }

    public function testHandleExceptionWithInvalidHandlerShouldThrowRuntimeException()
    {
        $this->expectException(InvalidExceptionHandlerException::class);

        $testObject = new FakeObject();
        $testObject->setName('Bob');
        $object = new ExceptionDecorator(
            $testObject,
            [new \stdClass()]
        );

        $object->thowException();
    }
}
