<?php

declare(strict_types=1);

namespace CCT\Component\RestExceptionHandler\Exception;

use Throwable;

class ApiBadRequestException extends ApiHttpException
{
    /**
     * @var array
     */
    protected $invalidParameters;

    public function __construct(
        $statusCode,
        $message = '',
        Throwable $previous = null,
        array $headers = [],
        array $invalidParameters = [],
        $code = 0
    ) {
        parent::__construct($statusCode, $message, $previous, $headers, $code);

        $this->invalidParameters = $invalidParameters;
    }

    /**
     * @return array
     */
    public function getInvalidParameters(): array
    {
        return $this->invalidParameters;
    }
}
