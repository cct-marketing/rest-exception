<?php

declare(strict_types=1);

use CCT\Component\RestExceptionHandler\Request\Handler\ApiGatewayExceptionHandler;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ApiGatewayExceptionHandlerTest extends TestCase
{
    public function testSupportsWithValidResponseHeaderShouldReturnTrue()
    {
        $request = new Request('GET','');
        $response = new Response(
            403,
            [
                'Date' => ['Mon, 09 Apr 2018 10:41:21 GMT'],
                'Content-Type' => ['application/json; charset=utf-8'],
                'Transfer-Encoding' => ['chunked'],
                'Connection' => ['keep-alive'],
                'Server' => ['kong/0.13.0']
            ]
        );

        $exception = new RequestException(
            'Client error: `GET https://web-scraping.cct.marketing/targets` resulted in a `403 Forbidden` 
            response:{"message":"Invalid authentication credentials"}',
            $request,
            $response
        );

        $apiGatewayExceptionHandler = new ApiGatewayExceptionHandler();
        $this->assertTrue($apiGatewayExceptionHandler->supports($exception));
    }

    public function testSupportsWithInValidResponseHeaderShouldReturnFalse()
    {
        $request = new Request('GET', '');
        $response = new Response(
            403,
            [
                'Date' => ['Mon, 09 Apr 2018 10:41:21 GMT'],
                'Content-Type' => ['application/problem+json;'],
                'Transfer-Encoding' => ['chunked'],
                'Connection' => ['keep-alive'],
                'Server' => ['kong/0.13.0']
            ]
        );

        $exception = new RequestException(
            'Invalid authentication credentials',
            $request,
            $response
        );

        $apiGatewayExceptionHandler = new ApiGatewayExceptionHandler();
        $this->assertFalse($apiGatewayExceptionHandler->supports($exception));
    }
}
