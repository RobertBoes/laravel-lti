<?php

namespace RobertBoes\LaravelLti\ToolProvider;

use RobertBoes\LaravelLti\LTI;

class ToolBase
{
    /**
     * @var \RobertBoes\LaravelLti\LTI
     */
    private $lti;

    public function __construct(LTI $lti)
    {
        $this->lti = $lti;
    }

    /**
     * Get the DataConnector
     * @return \IMSGlobal\LTI\ToolProvider\DataConnector\DataConnector
     */
    protected function dataConnector() {
        return $this->lti->getDataConnector();
    }
}