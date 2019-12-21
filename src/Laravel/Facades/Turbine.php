<?php

namespace StephaneCoinon\Turbine\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class Turbine extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \StephaneCoinon\Turbine\Turbine::class;
    }
}
