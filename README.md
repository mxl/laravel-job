# laravel-job
Laravel job tools:
- dispatch job from command line with parameters to queue or run synchronously;
- `Job` base class with boilerplate.

## Installation
```bash
$ composer require mxl/laravel-job
```

Laravel 5.5+ will use the [auto-discovery](https://medium.com/@taylorotwell/package-auto-discovery-in-laravel-5-5-ea9e3ab20518) feature to add `MichaelLedin\LaravelJob\LaravelJobServiceProvider::class` to providers.

This package is not compatible with older Laravel versions.

## Usage

### Dispatching job from command line to the queue

Make sure that you either use `sync` connection (see `default` property in `config/queue.php`) or run queue worker:

```bash
$ php artisan queue:work
```

Then dispatch command with:

```bash
$ php artisan job:dispatch YourJob
```

if `YourJob` class is located under `\App\Jobs` or specify full class name with namespace:

```bash
$ php artisan job:dispatch '\Path\To\YourJob'
```

### Running jobs immediately

If you want to run job right now without posting it to queue use `job:dispatchNow` command:

```bash
$ php artisan job:dispatchNow YourJob
``` 

### Dispatching jobs with parameters

```bash
$ php artisan job:dispatch YourJob John 1990-01-01
```

`John` and `1990-01-01` values will be passed to `YourJob` constructor as `$name` and `$birthDate` arguments:

```php
class YourJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    __constructor($name, $birthDate)
   {
       // ...
   }

   public function handle()
   {
       // ...
   }
}
```

### Using job with parameters from command line and PHP code

Often a job is already in use somewhere from PHP code and if it has constructor arguments that must have specific type, then it can be required to parse command line parameters.

For this purpose implement `FromParameters` interface:

```php
use MichaelLedin\LaravelJob\FromParameters;
use Carbon\Carbon;

class YourJob implements ShouldQueue, FromParameters
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
 
    __constructor(string $name, Carbon $birthDate)
    {
        // ...
    }
 
    public function handle()
    {
        // ...
    }

    public static function fromParameters(...$parameters)
    {
        return new self($parameters[0], Carbon::parse($parameters[1]));
    } 
}
```

### Job boilerplate

Job classes always use the same interface `ShouldQueue` and `Dispatchable`, `InteractsWithQueue`, `Queueable`, `SerializesModels` traits.

To avoid such boilerplate your jobs can extend `MichaelLedin\LaravelJob\Job` class:

```php
use MichaelLedin\LaravelJob\Job;
use Carbon\Carbon;

class YourJob extends Job
{
    // ...
}
```

It also includes default `FromParameters` interface implementation that is equivalent to calling constructor with arguments provided by command line parameters without any parsing.  
To add parsing override `fromParameters` method.

## Maintainers

- [@mxl](https://github.com/mxl)

## License

See the [LICENSE](https://github.com/mxl/laravel-job/blob/master/LICENSE) file for details.


