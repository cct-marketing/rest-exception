<?php

declare(strict_types=1);

namespace CCT\Component\RestExceptionHandler;

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
     */
    protected function handleException($exception): void
    {
        foreach ($this->exceptionHandlers as $exceptionHandler) {
            if (false === $exceptionHandler->supports($exception)) {
                continue;
            }

            $exceptionHandler->handle($exception);
        }

        throw $exception;
    }
}
