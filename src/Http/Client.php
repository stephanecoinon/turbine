<?php

namespace StephaneCoinon\Turbine\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

class Client
{
    /**
     * Underlying HTTP client.
     *
     * @var \GuzzleHttp\Client
     */
    protected $http;

    /**
     * Instantiate a new Client.
     *
     * @param string|null  $host
     */
    public function __construct($host = null)
    {
        $this->setClient(new GuzzleClient([
            'base_uri' => $host ?: getenv('TURBINE_HOST'),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'cookies' => true,
        ]));
    }

    /**
     * Set the underlying HTTP client instance.
     *
     * @param  \GuzzleHttp\Client  $client
     * @return $this
     */
    public function setClient(GuzzleClient $client)
    {
        $this->http = $client;

        return $this;
    }

    /**
     * Make a mock Client with pre-defined mock responses.
     *
     * @param  \GuzzleHttp\Psr7\Response[]  $responses
     * @return static
     */
    public static function mockResponses(array $responses)
    {
        return (new static)->setClient(
            new GuzzleClient([
                'handler' => HandlerStack::create(new MockHandler($responses))
            ])
        );
    }

    /**
     * Make a POST request.
     *
     * @param  string  $uri
     * @param  array  $params
     * @return \StephaneCoinon\Turbine\Http\Response
     */
    public function post($uri, array $params = []): Response
    {
        return new Response(
            $this->http->post($uri, ['body' => json_encode($params)])
        );
    }

    /**
     * Make a GET request.
     *
     * @param  string  $uri
     * @return \StephaneCoinon\Turbine\Http\Response
     */
    public function get($uri)
    {
        return new Response($this->http->get($uri));
    }
}
