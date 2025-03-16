<?php

namespace App\Infra\Integrations\Http;

class HttpResponse
{
    public function __construct(
        public readonly int $status,
        public readonly string $message,
        public readonly mixed $data = null,
    ) {}
}
