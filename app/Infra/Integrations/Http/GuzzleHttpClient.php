<?php

namespace App\Infra\Integrations\Http;

use GuzzleHttp\Client as Guzzle;

class GuzzleHttpClient implements HttpClient
{
    private static ?Guzzle $instance = null;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            return new Guzzle([
                'base_uri' => 'http://localhost:8001'
            ]);
        }

        return self::$instance;
    }

    public function get(string $path, $params = null): HttpResponse
    {
        $response = self::getInstance()->request('GET', $path);

        return new HttpResponse(
            $response->getStatusCode(),
            'success',
            json_decode($response->getBody()->getContents()),
        );
    }

    public function post(string $path, array $body = null)
    {
        $response = self::getInstance()->request(
            'POST',
            $path,
            ['json' => $body],
        );

        return new HttpResponse(
            $response->getStatusCode(),
            'success',
            json_decode($response->getBody()->getContents()),
        );
    }
}
