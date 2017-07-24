<?php

namespace RobertBoes\LaravelLti;

use Illuminate\Support\Facades\DB;
use IMSGlobal\LTI\ToolProvider\DataConnector;

class LTI
{
    public function __construct()
    {
        $db = DB::connection(config('laravel-lti.database.connection'))->getPdo();
        $this->data_connector = DataConnector\DataConnector::getDataConnector(config('laravel-lti.database.prefix'), $db);
    }

    public function toolConsumer()
    {

    }
}
