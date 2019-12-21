<?php

namespace StephaneCoinon\Turbine;

use DateTimeInterface;

class Team extends ApiModel
{
    protected $dateFormat = DateTimeInterface::RFC3339_EXTENDED;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
