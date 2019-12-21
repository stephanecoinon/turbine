<?php

namespace StephaneCoinon\Turbine;

class Employee extends ApiModel
{
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        $this->teams and $this->teams = collect($this->teams)->mapInto(Team::class);
        $this->state and $this->state = new State($this->state);
    }
}
