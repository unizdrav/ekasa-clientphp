<?php

namespace NineDigit\eKasa\Client\Models;

final class ResponseCount
{
    public int $start;

    public int $end;

    public int $total;

    public function __construct(int $start, int $end, int $total)
    {
        $this->start = $start;
        $this->end = $end;
        $this->total = $total;
    }
}
