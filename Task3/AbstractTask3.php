<?php

namespace Task3;

abstract class AbstractTask3
{
    protected string $baseUrl;

    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }
}