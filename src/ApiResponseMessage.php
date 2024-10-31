<?php

namespace NineDigit\eKasa\Client;

use GuzzleHttp\Psr7\Header;
use Exception;
use NineDigit\eKasa\Client\Exceptions\ResponseException;

final class ApiResponseMessage
{
    private int $statusCode;
    private array $headers;
    private ?string $content;

    public function __construct(int $statusCode = 204, array $headers = array(), ?string $content = null)
    {
        $this->statusCode = $statusCode;
        $this->headers = array();
        $this->content = $content;

        $this->setHeaders($headers);
    }

    public function isSuccessStatusCode(): bool
    {
        return $this->statusCode >= 200 && $this->statusCode <= 299;
    }

    /**
     * @throws ResponseException
     */
    public function ensureSuccessStatusCode()
    {
        $success = $this->isSuccessStatusCode();
        if (!$success) {
            $statusCode = $this->statusCode;
            throw new ResponseException($this->statusCode, "Response '$statusCode' does not indicate success.");
        }
    }

    public function getStatusCode(): int {
        return $this->statusCode;
    }

    public function hasStatusCode(int $value): bool {
        return $this->statusCode === $value;
    }

    public function getHeader(string $name): ?string {
        return $this->headers[strtolower($name)] ?? null;
    }

    public function getBooleanHeader(string $name, bool $default = false): bool {
        $header = $this->getHeader($name);
        return $header !== null ? boolval($header) : $default;
    }

    public function getHeaders(): array {
        return $this->headers;
    }

    public function setHeaders(array $headers): void {
        $this->headers = array();

        foreach ($headers as $name => $value) {
            $this->headers[strtolower($name)] = $value;
        }
    }

    /**
     * @deprecated Use getContent method instead.
     */
    public function getBody(): ?string {
        return $this->body;
    }

    public function getContent(): ?string {
        return $this->content;
    }

    public function getContentType(): ?string {
        return Header::parse($this->getHeader(HeaderName::CONTENT_TYPE))[0][0] ?? null;
    }

    public function hasContentType(...$contentTypes): bool {
        $contentType = $this->getContentType();
        return in_array($contentType, $contentTypes);
    }

    public function hasApplicationJsonContent(): bool {
        return $this->hasContentType(MediaTypeName::APPLICATION_JSON);
    }

    public function hasApplicationProblemJsonContent(): bool {
        return $this->hasContentType(MediaTypeName::APPLICATION_PROBLEM_JSON);
    }

    public function hasApplicationPdfContent(): bool {
        return $this->hasContentType(MediaTypeName::APPLICATION_PDF);
    }

    public function hasApplicationZipContent(): bool {
        return $this->hasContentType(MediaTypeName::APPLICATION_ZIP);
    }
}