<?php

namespace Schedule;

use Illuminate\Console\Application as Artisan;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Console\Scheduling\ScheduleRunCommand;
use Illuminate\Events\Dispatcher;

class ConsoleKernel
{
    protected $app;
    protected $artisan;
    protected $events;

    protected $commands = [
        #Register commads here!
    ];

    public function __construct(Application $app, Dispatcher $events)
    {
        $this->app = $app;
        $this->events = $events;
    }

    public function handle($input, $output = null)
    {
        $this->bootstrap();

        return $this->getArtisan()->run($input, $output);
    }

    protected function schedule(Schedule $schedule)
    {
        #Add to schedule taks here!
    }

    protected function bootstrap()
    {
        $schedule = new Schedule();

        $this->getArtisan()->add(
            new ScheduleRunCommand($schedule)
        );

        $this->schedule($schedule);
    }

    protected function getArtisan()
    {
        if (is_null($this->artisan)) {
            return $this->artisan = (new Artisan($this->app, $this->events, '5.8'))
                ->resolveCommands($this->commands);
        }

        return $this->artisan;
    }
}
