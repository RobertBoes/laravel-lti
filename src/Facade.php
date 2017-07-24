<?php

namespace RobertBoes\LaravelLti;

use Illuminate\Support\Facades\Facade as IlluminateFacade;

class Facade extends IlluminateFacade
{
    protected static function getFacadeAccessor()
    {
        return 'LTI';
    }
}
