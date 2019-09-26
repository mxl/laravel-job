<?php

namespace MichaelLedin\LaravelJob;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class Job implements ShouldQueue, FromParameters
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public static function fromParameters(string ...$parameters)
    {
        return new static(...$parameters);
    }
}
