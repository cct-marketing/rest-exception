<?php

declare(strict_types=1);

namespace CCT\Component\RestExceptionHandler\Request\Exception;

interface ApiHttpExceptionInterface
{

    /**
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * @return array
     */
    public function getHeaders(): array;
}
