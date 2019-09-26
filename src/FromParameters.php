<?php

namespace MichaelLedin\LaravelJob;

interface FromParameters
{
    static function fromParameters(string ...$parameters);
}