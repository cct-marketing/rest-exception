<?php

declare(strict_types=1);

namespace CCT\Component\RestExceptionHandler\Handlers;

use CCT\Component\RestExceptionHandler\Exception\ApiServiceUnavailableException;
use Exception;
use GuzzleHttp\Exception\ConnectException;

class ConnectExceptionHandler implements ExceptionHandlerInterface
{
    /**
     * @param Exception|ConnectException $exception
     *
     * @return mixed
     * @throws \CCT\Component\RestExceptionHandler\Exception\ApiServiceUnavailableException
     */
    public function handle(Exception $exception): void
    {
        $exception->getRequest();
        throw new ApiServiceUnavailableException(
            $exception->getRequest(),
            $exception->getMessage()
        );
    }

    /**
     * @param Exception $exception
     *
     * @return bool
     */
    public function supports(Exception $exception): bool
    {
        return $exception instanceof ConnectException;
    }
}
