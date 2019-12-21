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

    /**
     * Get the list of employees.
     *
     * @return \Illuminate\Support\Collection of \StephaneCoinon\Turbine\Employee
     */
    public function employees()
    {
        $response = $this->client->get('employees');

        return collect($response->json('collection'))->mapInto(Employee::class);
    }

    /**
     * Get the time-off entries for the logged in user.
     *
     * @return \Illuminate\Support\Collection of \StephaneCoinon\Turbine\TimeOff
     */
    public function timeOff()
    {
        $response = $this->client->get('timeoff');

        return collect($response->json('collection'))->mapInto(TimeOff::class);
    }
}
