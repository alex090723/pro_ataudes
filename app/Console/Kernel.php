<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        // Aquí puedes registrar tus comandos Artisan personalizados
    ];

    protected function schedule(Schedule $schedule)
    {
        // Programación de tareas
        $schedule->command('backup:run --only-db')->daily();
        $schedule->command('backup:run --only-db')->weekly();
        $schedule->command('backup:run --only-db')->monthly();
        $schedule->command('backup:run --only-db')->yearly();
    }

    protected function commands()
    {
        require base_path('routes/console.php');
    }
}