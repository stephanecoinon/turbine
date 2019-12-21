<?php

namespace StephaneCoinon\Turbine\Http;

use GuzzleHttp\Psr7\Response as GuzzleResponse;

class Response
{
    /**
     * HTTP status code.
     *
     * @var int
     */
    public $statusCode;

    /**
     * Response body as string.
     *
     * @var string
     */
    public $content;

    /**
     * Response as JSON object.
     *
     * @var Object
     */
    public $json;

    public function __construct(GuzzleResponse $response)
    {
        $this->statusCode = $response->getStatusCode();
        $this->content = $response->getBody()->getContents();
        // @TODO validate JSON
        $this->json = json_decode($this->content);
    }

    /**
     * Get an attribute from the JSON response.
     *
     * @param  string  $attribute
     * @return mixed
     */
    public function json($attribute = null)
    {
        if (!$attribute) {
            return $this->json;
        }

        return $this->json->$attribute ?? null;
    }

    public function succeeded()
    {
        return $this->json('success');
    }

    public function failed()
    {
        return !$this->succeeded();
    }

    public function errors()
    {
        return collect($this->json('errors') ?: []);
    }
}
