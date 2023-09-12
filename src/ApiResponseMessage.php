<?php

namespace NineDigit\eKasa\Client;

use Exception;

final class ApiResponseMessage
{
    public int $statusCode;
    public array $headers;
    public ?string $body;

    public function __construct(int $statusCode = 204, array $headers = array(), ?string $body = null)
    {
    }

    public function isSuccessStatusCode(): bool
    {
        return $this->statusCode >= 200 && $this->statusCode <= 299;
    }

    /**
     * @throws Exception
     */
    public function ensureSuccessStatusCode()
    {
        $success = $this->isSuccessStatusCode();
        if (!$success) {
            $statusCode = $this->statusCode;
            throw new Exception("Response '$statusCode' does not indicate success.");
        }
    }
}