<?php

declare(strict_types=1);

namespace CCT\Component\RestExceptionHandler\Handlers;

use Exception;

interface ExceptionHandlerInterface
{

    /**
     * @param Exception $exception
     *
     * @return mixed
     */
    public function handle(Exception $exception): void;

    /**
     * @param Exception $exception
     *
     * @return bool
     */
    public function supports(Exception $exception): bool;
}
