<?php

namespace App\Services;

use App\Exceptions\ProviderErrorException;
use App\Http\Requests\EmailSearchPostRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class ProviderService
{
    private Client $client;
    private string $accessToken;
    private array $config;

    public function __construct()
    {
    }

    /**
     * @param EmailSearchPostRequest $request
     * @return mixed
     */
    public function search(EmailSearchPostRequest $request): array
    {
        $searchParameters = $request->only($this->getConfig('searchParametersRequired'));
        $response = $this->request('get', $this->getConfig('searchPath'), [
            'query' => $searchParameters,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getAccessToken(),
            ]
        ]);
        $data = json_decode($response->getBody(), true);
        return ($data);
    }

    /**
     * @return void
     */
    public function setClient(): void
    {
        $this->client = new Client([
            'base_uri' => 'http://interview-api.stage1.beecoded.ro/',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ]);
    }

    /**
     * @return void
     */
    private function login(): void
    {
        $response = $this->request('post', 'auth/login', [
            'json' => [
                'email' => $this->getConfig('email'),
                'password' => $this->getConfig('password'),
            ]
        ]);
        $data = json_decode($response->getBody(), true);
        $this->setAccessToken($data['accessToken']);
    }

    /**
     * @return string
     */
    private function getAccessToken(): string
    {
        if (!empty($this->accessToken)) {
            return $this->accessToken;
        }
        $this->login();
        return $this->accessToken;
    }

    private function setAccessToken(string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     */
    private function request(string $method, $uri = '', array $options = []): ResponseInterface
    {
        try {
            return $this->client->request($method, $uri, $options);
        } catch (GuzzleException $e) {
            throw new ProviderErrorException($e);
        }
    }

    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    public function getConfig(string $key): string|array
    {
        return $key ? $this->config[$key] : $this->config;
    }
}
