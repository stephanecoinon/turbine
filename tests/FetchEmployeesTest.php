<?php

namespace StephaneCoinon\Turbine\Tests;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use StephaneCoinon\Turbine\Employee;
use StephaneCoinon\Turbine\Http\Client;
use StephaneCoinon\Turbine\State;
use StephaneCoinon\Turbine\Team;
use StephaneCoinon\Turbine\Turbine;

class FetchEmployeesTest extends TestCase
{
    function rawEmployee()
    {
        return [
            'id' => 1234,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'photo_url' => 'https://secure.gravatar.com/avatar/id-123',
            'job_title' => 'Office Administrator',
            'teams' => [
                [
                    'id' => 1,
                    'name' => 'All Admin',
                    'company_id' => 1,
                    'created_at' => '2012-09-19T17:07:27.000+01:00',
                    'updated_at' => '2018-05-10T07:57:32.000+01:00',
                    'permission_group_id' => 10,
                    'teammate_permission_group_id' => 11,
                    'editable' => true,
                    'teamviewer_permission_group_id' => 12
                ]
            ],
            'name' => 'John Doe',
            'state' => [
                'name' => 'active',
                'color' => 'active',
                'caption' => 'active'
            ]
        ];
    }

    /** @test */
    function get_list_of_employees()
    {
        $turbine = (new Turbine)->setClient(Client::mockResponses([
            new Response(200, [], json_encode([
                'collection' => [$this->rawEmployee()]
            ]))
        ]));

        $employees = $turbine->employees();

        $this->assertInstanceOf(Collection::class, $employees);
        $this->assertCount(1, $employees);
        $this->assertContainsOnlyInstancesOf(Employee::class, $employees);
        tap($employees->first(), function ($employee) {
            $this->assertEquals(1234, $employee->id);
            $this->assertEquals('John', $employee->first_name);
            $this->assertEquals('Doe', $employee->last_name);
            $this->assertEquals('john.doe@example.com', $employee->email);
        });
    }

    /** @test */
    function employee_teams_are_cast_to_their_own_model()
    {
        $turbine = (new Turbine)->setClient(Client::mockResponses([
            new Response(200, [], json_encode([
                'collection' => [$this->rawEmployee()]
            ]))
        ]));

        $teams = $turbine->employees()->first()->teams;

        $this->assertInstanceOf(Collection::class, $teams);
        $this->assertCount(1, $teams);
        $this->assertContainsOnlyInstancesOf(Team::class, $teams);
    }

    /** @test */
    function emloyee_state_is_cast_to_its_own_model()
    {
        $turbine = (new Turbine)->setClient(Client::mockResponses([
            new Response(200, [], json_encode([
                'collection' => [$this->rawEmployee()]
            ]))
        ]));

        $state = $turbine->employees()->first()->state;

        $this->assertInstanceOf(State::class, $state);
        $this->assertEquals([
            'name' => 'active',
            'color' => 'active',
            'caption' => 'active',
        ], $state->getAttributes());
    }
}
