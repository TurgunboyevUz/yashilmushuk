<?php

namespace Payme\Facades;

use Illuminate\Support\Facades\Facade;

class Payme extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'payme';
    }
}