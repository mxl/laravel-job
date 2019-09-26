<?php

namespace MichaelLedin\LaravelJob\Commands;

use Illuminate\Queue\Jobs\Job;
use InvalidArgumentException;
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
        $defaultNamespace = '\\App\\Jobs\\';
        if (!class_exists($class)) {
            $oldClass = $class;
            $class =  $defaultNamespace . $class;
            if (!class_exists($class)) {
                throw new InvalidArgumentException("$oldClass and $class classes do not exist.");
            }
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
