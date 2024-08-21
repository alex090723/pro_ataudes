<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class BackupController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-seguridad|crear-seguridad|editar-seguridad|borrar-seguridad', ['only' => ['index']]);
        $this->middleware('permission:crear-seguridad', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-seguridad', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-seguridad', ['only' => ['destroy']]);
    }

    public function index()
    {
        // Obtener la lista de backups en la carpeta 'laravel'
        $backups = Storage::disk('local')->files('laravel');

        return view('backup.index', ['backups' => $backups]);
    }

    public function createBackup(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'backup_type' => 'required|in:database,files',
        ]);

        // Configurar el comando según el tipo de backup seleccionado
        $backupType = $request->input('backup_type');

        try {
            // Ejecutar el comando de backup
            $command = $backupType === 'database' ? 'backup:run --only-db' : 'backup:run --only-files';
            $exitCode = Artisan::call($command);
            $output = Artisan::output(); // Captura la salida del comando

            // Agregar registros de depuración
            Log::info("Command executed: $command");
            Log::info("Exit code: $exitCode");
            Log::info("Output: $output");

            // Verifica si el comando se ejecutó correctamente
            if ($exitCode === 0) {
                // Redirigir con mensaje de éxito
                return redirect()->route('backup.index')->with('status', 'Backup creado exitosamente!');
            } else {
                // Redirigir con mensaje de error detallado
                return redirect()->route('backup.index')->with('error', 'Error al crear el backup. Detalles: ' . $output);
            }
        } catch (\Exception $e) {
            // Captura cualquier excepción y redirige con mensaje de error
            Log::error('Backup creation failed', ['exception' => $e]);
            return redirect()->route('backup.index')->with('error', 'Error al crear el backup. Detalles: ' . $e->getMessage());
        }
    }

    public function scheduleBackup(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'frequency' => 'required|in:daily,weekly,monthly,yearly',
            'backup_type' => 'required|in:database,files',
        ]);

        // Obtener la frecuencia y el tipo de backup
        $frequency = $request->input('frequency');
        $backupType = $request->input('backup_type');
        $command = $backupType === 'database' ? 'backup:run --only-db' : 'backup:run --only-files';

        // Programar el backup usando el planificador de Laravel
        $schedule = Cache::get('backup_schedule', []);
        $schedule[$frequency] = $command;
        Cache::put('backup_schedule', $schedule, now()->addDays(365));

        // Redirigir con mensaje de éxito
        return redirect()->route('backup.index')->with('status', 'Backup programado exitosamente!');
    }

    public function restoreBackup(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'backup_path' => 'required|string',
        ]);

        // Obtener la ruta del backup
        $backupPath = $request->input('backup_path');

        try {
            // Lógica para restaurar el backup desde el archivo
            // Por ejemplo, si es una base de datos, podrías usar una herramienta de línea de comandos para importarla.
            $backupFilePath = storage_path('app/' . $backupPath);
            
            // Ejecutar el comando para restaurar la base de datos (esto es solo un ejemplo)
            $command = "mysql -u username -p password database_name < $backupFilePath";
            $exitCode = shell_exec($command);
            
            // Agregar registros de depuración
            Log::info("Command executed: $command");
            Log::info("Exit code: $exitCode");
            
            // Verifica si el comando se ejecutó correctamente
            if ($exitCode === 0) {
                // Redirigir con mensaje de éxito
                return redirect()->route('backup.index')->with('status', 'Backup restaurado exitosamente!');
            } else {
                // Redirigir con mensaje de error detallado
                return redirect()->route('backup.index')->with('error', 'Error al restaurar el backup.');
            }
        } catch (\Exception $e) {
            // Captura cualquier excepción y redirige con mensaje de error
            Log::error('Backup restoration failed', ['exception' => $e]);
            return redirect()->route('backup.index')->with('error', 'Error al restaurar el backup. Detalles: ' . $e->getMessage());
        }
    }
}
