<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BackupDatabaseCommand extends Command
{
    protected $signature = 'db-backup';
    protected $description = 'Backup the database';

    public function handle()
    {
        $filename = 'backup' . now()->format('Y-m-d') . '.sql';
        $command = 'mysqldump --user=' . env('DB_USERNAME') . ' --password=' . env('DB_PASSWORD')
         . ' --host=' . env('DB_HOST') . ' ' . env('DB_DATABASE') . ' > ' . storage_path() . '/app/backup/' . $filename;
        $returnVar = NULL;
        $output = NULL;
        exec($command, $output, $returnVar);

        Log::info('Database backup completed.');
    }
}
