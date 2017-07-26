<?php

namespace RobertBoes\LaravelLti\Commands;

use Illuminate\Console\Command;
use IMSGlobal\LTI\ToolProvider\ToolConsumer;
use RobertBoes\LaravelLti\LTI;

class CreateToolConsumerCommand extends Command
{
    protected $signature = 'lti:create-tool-consumer';

    protected $description = 'Creates a new tool consumer';

    /**
     * @var \RobertBoes\LaravelLti\LTI
     */
    protected $lti;

    protected $toolConsumer;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->lti = new LTI();
        $this->toolConsumer = $this->lti->toolConsumer();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $key = $this->ask('New ToolConsumer key');
        $this->toolConsumer->create($key);
        $name = $this->ask('ToolConsumer Name');
        $this->toolConsumer->name = $name;
        $secret = $this->ask('ToolConsumer Secret');
        $this->toolConsumer->secret = $secret;
        $asking = true;
        $this->info('Add optional parameters, enter "exit" to stop and save the new ToolConsumer');
        while($asking) {
            $property = $this->ask('Set property');
            if($property === 'exit') {
                $asking = false;
            }
            else {
                $value = $this->ask('Value of '. $property);
                $this->toolConsumer->{$property} = $value;
            }
        }
        $this->toolConsumer->save();
        return;
    }
}
