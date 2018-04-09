<?php

declare(strict_types=1);

namespace CCT\Component\RestExceptionHandler;

use CCT\Component\RestExceptionHandler\Exception\InvalidExceptionHandlerException;
use CCT\Component\RestExceptionHandler\Request\Handler\ExceptionHandlerInterface;
use \Exception;
use function call_user_func_array;

class ExceptionDecorator
{
    /**
     * @var Object
     */
    protected $object;

    /**
     * @var array
     */
    protected $exceptionHandlers;

    /**
     * ExceptionDecorator constructor.
     *
     * @param object $object
     * @param array $exceptionHandlers
     */
    public function __construct($object, array $exceptionHandlers = [])
    {
        $this->object = $object;
        $this->exceptionHandlers = $exceptionHandlers;
    }

    /**
     * Expose all request methods and guard against
     * their exceptions.
     *
     * @param $method
     * @param $args
     *
     * @return mixed|void
     * @throws \RuntimeException
     */
    public function __call($method, $args)
    {
        try {
            return call_user_func_array(array($this->object, $method), $args);
        } catch (Exception $exception) {
            $this->handleException($exception);
            return;
        }
    }

    /**
     * Default callback to handle exception
     *
     * @param $exception
     *
     * @throws \RuntimeException
     */
    protected function handleException($exception): void
    {
        foreach ($this->exceptionHandlers as $exceptionHandler) {
            if (!$exceptionHandler instanceof ExceptionHandlerInterface) {
                throw new InvalidExceptionHandlerException(
                    'Exception handler must be an instance of ' . ExceptionHandlerInterface::class
                );
            }

            if (false === $exceptionHandler->supports($exception)) {
                continue;
            }

            $exceptionHandler->handle($exception);
        }

        throw $exception;
    }

    /**
     * @param string $className
     *
     * @return bool
     */
    public function instanceOf(string $className): bool
    {
        return $this->object instanceof $className;
    }
}
