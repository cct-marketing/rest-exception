<?php

declare(strict_types=1);

namespace CCT\Component\RestExceptionHandler\Handlers;

use CCT\Component\RestExceptionHandler\Exception\ApiGatewayException;
use Exception;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use function in_array;

class ApiGatewayExceptionHandler implements ExceptionHandlerInterface
{
    /**
     * @param Exception|RequestException $exception
     *
     * @return void
     * @throws \GuzzleHttp\Exception\RequestException
     * @throws \CCT\Component\RestExceptionHandler\Exception\ApiGatewayException
     */
    public function handle(Exception $exception): void
    {
        if (false === $exception->hasResponse()) {
            throw $exception;
        }

        $response = $exception->getResponse();

        throw new ApiGatewayException(
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
        return in_array('application/json', $contentType, false);
    }

    /**
     * @param ResponseInterface|Response $response
     *
     * @return string
     */
    protected function extractMessage(ResponseInterface $response): string
    {
        $content = \GuzzleHttp\json_decode($response->getBody(), true);
        if (array_key_exists('message', $content)) {
            return $content['message'];
        }

        return 'Unknown error occurred';
    }
}
