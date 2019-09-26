<?php


namespace MichaelLedin\LaravelJob\Commands;


class DispatchNow extends Dispatch
{
    protected $description = 'Dispatch job immediately (synchronously)';

    public function __construct()
    {
        parent::__construct('Now');
    }

    protected function dispatch($job)
    {
        dispatch_now($job);
    }
}