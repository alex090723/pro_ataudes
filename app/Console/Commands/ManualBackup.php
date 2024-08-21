<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Backup\BackupNotification\BackupSuccessfulNotification;

class ManualBackup extends Command
{
    protected $signature = 'backup:manual';
    protected $description = 'Create a manual backup of the project';

    public function handle()
    {
        $this->call('backup:run');
        $this->info('Backup created successfully!');
    }
}