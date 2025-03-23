<?php

namespace App\Infra\Integrations;

use App\Infra\Integrations\Http\HttpClient;
use App\Infra\Integrations\Http\HttpResponse;
use App\Infra\Integrations\Http\LambdaHttpClient;
use Core\Application\Contracts\Services\AuthService;
use Core\Application\Dtos\Auth\AuthenticatedDto;
use Core\Application\Dtos\Auth\AuthorizedDto;

class LambdaAuthService implements AuthService
{
    private HttpClient $client;

    public function __construct()
    {
        $this->client = new LambdaHttpClient();
    }

    public function authenticate(string $cpf): AuthenticatedDto
    {
        /** @var HttpResponse */
        $response = $this->client->post('/authentication', ['cpf' => $cpf]);

        return new AuthenticatedDto($response->data->code, $response->data->accessToken);
    }

    public function authorizate(string $token): AuthorizedDto
    {
        /** @var HttpResponse */
        $response = $this->client->post('/authorization', ['token' => $token]);

        return new AuthorizedDto($response->data->code);
    }
}
