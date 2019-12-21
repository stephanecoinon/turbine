<?php

namespace StephaneCoinon\Turbine\Tests;

use Carbon\Carbon;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use StephaneCoinon\Turbine\Employee;
use StephaneCoinon\Turbine\Http\Client;
use StephaneCoinon\Turbine\State;
use StephaneCoinon\Turbine\Tests\TestCase;
use StephaneCoinon\Turbine\TimeOff;
use StephaneCoinon\Turbine\Turbine;

class FetchTimeOffEntriesTest extends TestCase
{
    public function rawTimeOff()
    {
        return [
            'id' => 1,
            'can_edit' => false,
            'identifier' => 'TO-01234',
            'type' => 'TimeOff',
            'can_see' => true,
            'title' => '',
            'notes' => null,
            'additional_info' => '',
            'company' => [
                'id' => 1,
                'name' => 'Acme'
            ],
            'is_draft' => false,
            'state' => [
                'name' => 'approved',
                'color' => 'green',
                'caption' => 'Approved'
            ],
            'warnings' => [
                'state' => ''
            ],
            'available_states' => [
                [
                    'name' => 'pending',
                    'color' => 'yellow',
                    'caption' => 'Pending',
                    'url' => '/api/v1/demands/1/state_changes?demand%5Bstate%5D=pending'
                ],
                [
                    'name' => 'completed',
                    'color' => 'grey',
                    'caption' => 'Taken',
                    'url' => '/api/v1/demands/1/state_changes?demand%5Bstate%5D=completed'
                ]
            ],
            'description_min' => '2019-12-23',
            'description_max' => '2019-12-24',
            'description_count' => 2,
            'description_sum' => '2.0',
            'description_full' => '2019-12-23 1.0, 2019-12-24 1.0',
            'demand_type_name' => 'Holiday',
            'user' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'middle_name' => '',
                'salutation' => '',
                'email' => 'john@example.com',
                'job_title' => 'Office administrator',
                'phone_number' => '01234 567890',
                'id' => 1,
                'photo_url' => 'https://secure.gravatar.com/avatar/id-123',
                'name' => 'John Doe',
                'deleted' => false
            ],
            'created_at' => 'Nov 13 ',
            'updated_at' => 'Nov 15',
            'export' => [
                'pdf' => [
                    'title' => 'Save as PDF',
                    'url' => '/api/v1/time_off/1.pdf'
                ],
                'ics' => [
                    'title' => 'Save as ics',
                    'url' => '/api/v1/time_off/1.ics'
                ]
            ],
            'taken_days' => 'Dec 23 - 24',
            'timestatus' => 'future'
        ];
    }

    /** @test */
    function get_list_of_time_off_entries_of_the_logged_in_user()
    {
        $turbine = (new Turbine)->setClient(Client::mockResponses([
            new Response(200, [], json_encode([
                'collection' => [$this->rawTimeOff()]
            ]))
        ]));

        $timesOff = $turbine->timeOff();

        $this->assertInstanceOf(Collection::class, $timesOff);
        $this->assertCount(1, $timesOff);
        $this->assertContainsOnlyInstancesOf(TimeOff::class, $timesOff);
        tap($timesOff->first(), function ($timeOff) {
            $this->assertEquals(1, $timeOff->id);
            $this->assertEquals('TO-01234', $timeOff->identifier);
            $this->assertInstanceOf(State::class, $timeOff->state);
            $this->assertInstanceOf(Collection::class, $timeOff->available_states);
            $this->assertContainsOnlyInstancesOf(State::class, $timeOff->available_states);
            $this->assertInstanceOf(Carbon::class, $timeOff->description_min);
            $this->assertInstanceOf(Carbon::class, $timeOff->description_max);
            $this->assertInstanceOf(Employee::class, $timeOff->user);
        });
    }
}
