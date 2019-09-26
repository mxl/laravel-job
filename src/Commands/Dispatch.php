<?php

namespace MichaelLedin\LaravelJob\Commands;

use Illuminate\Queue\Jobs\Job;
use MichaelLedin\LaravelJob\FromParameters;

class Dispatch extends Command
{
    protected $description = 'Dispatch job';

    public function __construct(string $name = '')
    {
        parent::__construct('dispatch' . $name, '{job} {params?*}');
    }

    public function handle()
    {
        /** @var Job|FromParameters $class */
        $class = $this->argument('job');
        if (!class_exists($class)) {
            $class = '\\App\\Jobs\\' . $class;
        }
        $parameters = $this->argument('params') ?? [];
        $job = in_array(FromParameters::class, class_implements($class)) ? $class::fromParameters(...$parameters) : new $class(...$parameters);
        $this->dispatch($job);
    }

    protected function dispatch($job)
    {
        dispatch($job);
    }
}
