<?php

declare(strict_types=1);

namespace CCT\Component\RestExceptionHandler\Request\Exception;

use Throwable;

class ApiHttpException extends \RuntimeException implements ApiHttpExceptionInterface
{
    /**
     * Http status code
     * @var integer
     */
    protected $statusCode;

    /**
     * Response headers
     * @var array
     */
    protected $headers;

    public function __construct(
        int $statusCode,
        $message = '',
        Throwable $previous = null,
        array $headers = array(),
        $code = 0
    ) {
        parent::__construct($message, $code, $previous);
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}
