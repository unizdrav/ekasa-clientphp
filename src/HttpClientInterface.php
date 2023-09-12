<?php

namespace NineDigit\eKasa\Client;

interface HttpClientInterface
{
    public function send(ApiRequest $request): void;

    public function receive(ApiRequest $request, $type);
}