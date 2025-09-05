<?php

namespace App\Console;

use App\Console\Commands\CleanLibraryCommand;
use App\Console\Commands\ClearCacheCommand;
use App\Console\Commands\ClearLibraryCommand;
use App\Console\Commands\DeleteImagesCommand;
use App\Console\Commands\DownloadStreamCommand;
use App\Console\Commands\PlayBackInfoCommand;
use App\Console\Commands\RebuildLibraryCommand;
use App\Console\Commands\RemoveItemCommand;
use App\Console\Commands\SaveItemCommand;
use App\Console\Commands\TestCommand;
use App\Console\Commands\UpdateItemCommand;
use App\Console\Commands\UpdateLibraryCommand;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //IMDbDatasetRetriever::class,
        TestCommand::class,
        ClearCacheCommand::class,

        //Jellyfin Commands
        ClearLibraryCommand::class,
        CleanLibraryCommand::class,
        UpdateLibraryCommand::class,
        RebuildLibraryCommand::class,
        PlayBackInfoCommand::class,
        SaveItemCommand::class,
        RemoveItemCommand::class,
        UpdateItemCommand::class,
        DownloadStreamCommand::class,
        DeleteImagesCommand::class,
        //JellyfinSetupCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(ClearCacheCommand::class)->everyTwoHours();

        if(!empty(cstr_config('tasks.cron.'.md5('library:clean'))))
            $schedule->command(CleanLibraryCommand::class)->cron(cstr_config('tasks.cron.'.md5('library:clean')));
        if(!empty(cstr_config('tasks.cron.'.md5('library:update'))))
            $schedule->command(UpdateLibraryCommand::class)->cron(cstr_config('tasks.cron.'.md5('library:update')));
        if(!empty(cstr_config('tasks.cron.'.md5('library:rebuild'))))
            $schedule->command(RebuildLibraryCommand::class)->cron(cstr_config('tasks.cron.'.md5('library:rebuild')));
        if(!empty(cstr_config('tasks.cron.'.md5('library:playback-info'))))
            $schedule->command(PlayBackInfoCommand::class)->cron(cstr_config('tasks.cron.'.md5('library:playback-info')));
        if(!empty(cstr_config('tasks.cron.'.md5('delete:images'))))
            $schedule->command(DeleteImagesCommand::class)->cron(cstr_config('tasks.cron.'.md5('delete:images')));
    }
}
