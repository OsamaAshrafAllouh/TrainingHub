<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\StreamHandler;

class AdvisorLogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $advisorId = Auth::check() ? Auth::id() : 'guest';
        $logFileName = 'advisor_' . $advisorId . '.log';
        Log::channel('advisor')->getLogger()->setHandlers([new StreamHandler(storage_path('logs/' . $logFileName), config('logging.levels.advisor'))]);
    }
}
