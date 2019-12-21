<?php

namespace StephaneCoinon\Turbine;

class Employee extends ApiModel
{
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        $this->teams = collect($this->teams)->mapInto(Team::class);
        $this->state = new EmployeeState($this->state);
    }
}
