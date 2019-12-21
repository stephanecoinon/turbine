<?php

namespace StephaneCoinon\Turbine;

use StephaneCoinon\Turbine\Exceptions\AuthenticationException;
use StephaneCoinon\Turbine\Http\Client;

class Turbine
{
    /**
     * API client.
     *
     * @var \StephaneCoinon\Turbine\Http\Client
     */
    protected $client;

    public function __construct($host = null)
    {
        $this->client = new Client($host);
    }

    /**
     * Set the API client instance.
     *
     * @param  \StephaneCoinon\Turbine\Http\Client $client
     * @return $this
     */
    public function setClient(Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Authenticate into the API.
     *
     * @param  string  $email
     * @param  string  $password
     * @return $this
     *
     * @throws Exceptions\AuthenticationException
     */
    public function login($email, $password)
    {
        $response = $this->client->post(
            'https://cdn.turbinehq.com/api/v1/sign_in',
            compact('email', 'password')
        );

        if ($response->failed()) {
            throw new AuthenticationException($response->errors()->flatten()->first());
        }

        return $this;
    }
}
