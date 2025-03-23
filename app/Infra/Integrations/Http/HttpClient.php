<?php

namespace App\Infra\Integrations\Http;

interface HttpClient
{
    public function get(string $path, $params = null): HttpResponse;

    public function post(string $path, array $body = null);
}
