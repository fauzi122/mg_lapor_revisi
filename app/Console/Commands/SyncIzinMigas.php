<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Jobs\SaveIzinMigasJob;

class SyncIzinMigas extends Command
{
    protected $signature = 'migas:sync';
    protected $description = 'Menjalankan SaveIzinMigasJob untuk semua user yang memiliki NPWP';

    public function handle()
    {
        $this->info('Memulai sinkronisasi data MIGAS...');
        $users = User::whereNotNull('npwp')
            ->where('npwp', '!=', '')
            ->pluck('npwp');
        $total = count($users);
        $count = 0;
        // dd($users);
        foreach ($users as $npwp) {
            dispatch(new SaveIzinMigasJob($npwp));
            $count++;
            $this->line("[$count/$total] Job dikirim untuk NPWP: $npwp");
            usleep(200000); // jeda 200ms kalau mau atur throttle API
        }

        $this->info('✅ Semua job sinkronisasi telah dijalankan.');
        return 0;
    }
}
