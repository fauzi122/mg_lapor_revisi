<?php

namespace App\Console;

use App\Jobs\bph\SyncJbkpKuota;
use App\Jobs\bph\SyncJbtKuota;
use App\Jobs\bph\SyncPasokanBbm;
use App\Jobs\bph\SyncPasokanGasBumi;
use App\Jobs\bph\SyncPengangkutanGasBumi;
use App\Jobs\bph\SyncPenjualanGasBumi;
use App\Jobs\bph\SyncPenjualanJbkp;
use App\Jobs\bph\SyncPenjualanJbt as BphSyncPenjualanJbt;
use App\Jobs\bph\SyncPenjualanJbu;
use Illuminate\Console\Scheduling\Schedule;
use App\Jobs\SyncPenjualanJbt;
use App\Jobs\SyncJbtJob;
use Carbon\Carbon;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $year = Carbon::now()->year;

        $schedule->call(function () use ($year) {
            SyncPenjualanJbkp::dispatch($year);
        })->dailyAt('20:00');

        $schedule->call(function () use ($year) {
            BphSyncPenjualanJbt::dispatch($year);
        })->dailyAt('21:00');

        $schedule->call(function () use ($year) {
            SyncPenjualanJbu::dispatch($year);
        })->dailyAt('22:00');

        $schedule->call(function () use ($year) {
            SyncPasokanBbm::dispatch($year);
        })->dailyAt('23:00');

        $schedule->call(function () use ($year) {
            SyncPenjualanGasBumi::dispatch($year);
        })->dailyAt('00:00');

        $schedule->call(function () use ($year) {
            SyncPasokanGasBumi::dispatch($year);
        })->dailyAt('01:00');

        $schedule->call(function () use ($year) {
            SyncPengangkutanGasBumi::dispatch($year);
        })->dailyAt('02:00');

        $schedule->call(function () use ($year) {
            SyncJbtKuota::dispatch($year);
        })->dailyAt('03:00');

        $schedule->call(function () use ($year) {
            SyncJbkpKuota::dispatch($year);
        })->dailyAt('04:00');
        // $schedule->command('inspire')->hourly();

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
