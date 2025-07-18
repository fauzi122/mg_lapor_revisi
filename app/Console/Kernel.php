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
        $schedule->call(function () {
            $year = Carbon::now()->year;
            // SyncJbtJob::dispatchSync($startYear);
            SyncPenjualanJbkp::dispatchSync($year);
            BphSyncPenjualanJbt::dispatchSync($year);
            SyncPenjualanJbu::dispatchSync($year);
            SyncPasokanBbm::dispatchSync($year);
            SyncPenjualanGasBumi::dispatchSync($year);
            SyncPasokanGasBumi::dispatchSync($year);
            SyncPengangkutanGasBumi::dispatchSync($year);
            SyncJbtKuota::dispatchSync($year);
            SyncJbkpKuota::dispatchSync($year);
        })->dailyAt('15:15'); // Menjadwalkan job setiap hari pukul 01:00 AM
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
