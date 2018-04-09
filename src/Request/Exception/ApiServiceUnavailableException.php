<?php

declare(strict_types=1);

namespace CCT\Component\RestExceptionHandler\Request\Exception;

use Psr\Http\Message\RequestInterface;
use Throwable;

class ApiServiceUnavailableException extends ApiHttpException
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * ServiceUnavailableException constructor.
     *
     * @param RequestInterface $request
     * @param string $message
     * @param int $statusCode
     * @param Throwable|null $previous
     * @param int $code
     */
    public function __construct(
        RequestInterface $request,
        string $message,
        int $statusCode = 503,
        Throwable $previous = null,
        $code = 0
    ) {
        $this->request = $request;

        parent::__construct($statusCode, $message, $previous, [], $code);
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }
}
