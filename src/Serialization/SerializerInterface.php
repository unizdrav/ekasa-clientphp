<?php

namespace NineDigit\eKasa\Client\Serialization;

interface SerializerInterface
{
    function serialize($data): string;

    function deserialize($data, $type);
}