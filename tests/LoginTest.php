<?php

namespace StephaneCoinon\Turbine\Tests;

use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response;
use Mockery;
use StephaneCoinon\Turbine\Exceptions\AuthenticationException;
use StephaneCoinon\Turbine\Http\Client;
use StephaneCoinon\Turbine\Turbine;

class LoginTest extends TestCase
{
    /** @test */
    function logging_in_with_valid_credentials()
    {
        $http = Mockery::mock(GuzzleClient::class);
        $http->shouldReceive('post')->with(
            'https://cdn.turbinehq.com/api/v1/sign_in',
            [
                'body' => json_encode([
                    'email' => 'valid_email@example.com',
                    'password' => 'valid_password'
                ])
            ]
        )->andReturn(new Response(200, [], '{"success":true,"authenticated":true,"user":{"id":2592}}'));

        $turbine = (new Turbine)->setClient((new Client)->setClient($http));

        $turbine->login('valid_email@example.com', 'valid_password');

        $this->pass();
    }

    /** @test */
    function logging_in_with_invalid_credentials()
    {
        $turbine = (new Turbine)->setClient((new Client)->mockResponses([
            // API does return status 200 (OK) even though authentication failed
            new Response(200, [], '{"success":false,"errors":{"email":["Invalid email or password."]}}'),
        ]));

        try {
            $turbine->login('email@example.com', 'invalid_password');
        } catch (AuthenticationException $e) {
            $this->assertEquals('Invalid email or password.', $e->getMessage());
            return;
        } catch (Exception $e) {
            $this->fail('Expected AuthenticationException but caught ' . get_class($e));
        }

        $this->fail('Expected AuthenticationException but none was thrown.');
    }
}
