<?php


namespace MichaelLedin\LaravelJob\Commands;


class Command extends \Illuminate\Console\Command
{
    public function __construct(string $name, string $params)
    {
        $this->signature = 'job:' . $name . ' ' . $params;
        parent::__construct();
    }
}