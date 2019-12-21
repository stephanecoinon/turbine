<?php

namespace StephaneCoinon\Turbine;

class TimeOff extends ApiModel
{
    protected $dateFormat = 'Y-m-d';

    protected $casts = [
        'description_min' => 'datetime',
        'description_max' => 'datetime',
    ];

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        $this->state = new State($this->state);
        $this->available_states = collect($this->available_states)->mapInto(State::class);
        $this->user = new Employee($this->user);
    }
}
