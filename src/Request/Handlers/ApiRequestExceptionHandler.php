<?php

declare(strict_types=1);

namespace CCT\Component\RestExceptionHandler\Handlers;

use CCT\Component\RestExceptionHandler\Exception\ApiBadRequestException;
use CCT\Component\RestExceptionHandler\Exception\ApiRequestException;
use Exception;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use function in_array;

class ApiRequestExceptionHandler implements ExceptionHandlerInterface
{
    /**
     * @param Exception|RequestException $exception
     *
     * @return mixed
     * @throws \CCT\Component\RestExceptionHandler\Exception\ApiBadRequestException
     * @throws \CCT\Component\RestExceptionHandler\Exception\ApiRequestException
     * @throws \GuzzleHttp\Exception\RequestException
     */
    public function handle(Exception $exception): void
    {

        if (false === $exception->hasResponse()) {
            throw $exception;
        }

        $response = $exception->getResponse();

        if ($response->getStatusCode() === 400) {
            throw new ApiBadRequestException(
                $response->getStatusCode(),
                $this->extractMessage($response),
                $exception,
                $response->getHeaders(),
                $this->extractInvalidParams($response)
            );
        }

        throw new ApiRequestException(
            $response->getStatusCode(),
            $this->extractMessage($response),
            $exception,
            $response->getHeaders()
        );
    }

    /**
     * @param Exception $exception
     *
     * @return bool
     */
    public function supports(Exception $exception): bool
    {
        return ($exception instanceof RequestException
            && $exception->hasResponse()
            && $this->validContentType($exception->getResponse()->getHeader('Content-Type'))
        );
    }

    /**
     * @param array $contentType
     *
     * @return bool
     */
    protected function validContentType(array $contentType): bool
    {
        return in_array('application/problem+json', $contentType, false);
    }

    /**
     * Extract message from server response
     *
     * @param $response
     *
     * @return string
     */
    protected function extractMessage(ResponseInterface $response): string
    {
        $content = \GuzzleHttp\json_decode((string)$response->getBody(), true);
        if (array_key_exists('message', $content)) {
            return $content['detail'];
        }

        return 'Unknown error occurred';
    }

    /**
     * Extract invalid-param from server response
     *
     * @param ResponseInterface $response
     *
     * @return array
     */
    protected function extractInvalidParams(ResponseInterface $response): array
    {
        $content = \GuzzleHttp\json_decode((string)$response->getBody(), true);
        if (array_key_exists('message', $content)) {
            return $content['invalid-params'];
        }

        return [];
    }
}
