<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;




use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class BackupPostgresDatabase extends Command
{
    protected $signature = 'backup:postgres';

    protected $description = 'Backup PostgreSQL database';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info(json_encode(['status' => 'success', 'message' => 'Command completed.']));

        $host = env('DB_HOST', 'localhost');
        $port = env('DB_PORT', '5432');
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $pg_dump = env('PG_DUMP');
        $backupFile = public_path('backup/' . date('Y-m-d_His') . '.backup');




        $command = [
            $pg_dump,
            '--host=' . $host,
            '--port=' . $port,
            '--dbname=' . $database,
            '--username=' . $username,
            '--file=' . $backupFile,
            '--username=' . $username,
            // '--password=' . $password,
            '--no-password',
        ];

        // if ($password) {
        //     $command[] = '--password=' . $password;
        // }

        $process = new Process($command);
        $process->setTimeout(null); // Remove timeout limit

        $process->run();

        if ($process->isSuccessful()) {
            // echo $backupFile;
         $this->info('Backup completed successfully.');

        } else {
            $this->error('Backup failed: ' . $process->getErrorOutput());
        }
    }
}
