<?php

namespace NineDigit\eKasa\Client\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use NineDigit\eKasa\Client\ApiClientOptions;
use NineDigit\eKasa\Client\ApiResponseMessage;
use NineDigit\eKasa\Client\Exceptions\ProblemDetailsException;
use NineDigit\eKasa\Client\HttpClient;
use PHPUnit\Framework\Assert;
use Throwable;

final class TestableHttpClient extends HttpClient {
    public function __construct(ApiClientOptions $options) {
        parent::__construct($options);
        
    }

    public function callThrowOnError(ApiResponseMessage $response)
    {
        return $this->throwOnError($response);
    }
};

final class HttpClientTest extends TestCase {
    public function testThrowOnErrorThrowsStatusCodeProblemDetailsForResponseWithErrorStatusCodeAndNoBody() {
        $apiClientOptions = new ApiClientOptions();
        $client = new TestableHttpClient($apiClientOptions);
        $response = new ApiResponseMessage(403);
        $error = null;

        try {
            $client->callThrowOnError($response);
        } catch (Throwable $e) {
            $error = $e;
        }

        $this->assertNotNull($error);
        $this->assertInstanceOf(ProblemDetailsException::class, $error);
        $this->assertEquals(403, $error->statusCode);
    }
}