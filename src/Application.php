<?php

namespace Schedule;

use Illuminate\Cache\CacheManager;
use Illuminate\Console\Scheduling\CacheEventMutex;
use Illuminate\Console\Scheduling\EventMutex;
use Illuminate\Container\Container;
use Illuminate\Contracts\Cache\Factory;

class Application extends Container
{
    public function __construct()
    {
        $this->registerBaseBindings();
        $this->registerScheduleBindings();
    }

    protected function registerBaseBindings()
    {
        static::setInstance($this);
        $this->instance('app', $this);
        $this->instance(Container::class, $this);
    }

    protected function registerScheduleBindings()
    {
        $this->bind(
            Factory::class,
            function ($app) {
                return new CacheManager($app);
            }
        );

        $this->bind(EventMutex::class, CacheEventMutex::class);
        $this->bind(SchedulingMutex::class, CacheSchedulingMutex::class);
    }

    public function environment()
    {
        return 'prod';
    }

    public function isDownForMaintenance()
    {
        return false;
    }
}
