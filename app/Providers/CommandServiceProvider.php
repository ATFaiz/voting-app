<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Console\Commands\SendConstituencyVoteNotification;


class CommandServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('command.send-constituency-vote-notification', function () {
            return new SendConstituencyVoteNotification();
        });

        $this->commands([
            'command.send-constituency-vote-notification',
        ]);
    }
}

