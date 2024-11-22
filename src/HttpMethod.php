<?php

namespace NineDigit\eKasa\Client;

final class HttpMethod
{
    public const GET = "GET";
    public const POST = "POST";
    public const PUT = "PUT";
    public const DELETE = "DELETE";
    public const HEAD = "HEAD";

    private function __construct()
    {
    }
}