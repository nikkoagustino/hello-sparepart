<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Config;

class BackupController extends Controller
{

    public function backupDatabase()
    {
        $databaseConfig = Config::get('database.connections.mysql');
        $databaseName = $databaseConfig['database'];
        $userName = $databaseConfig['username'];
        $password = $databaseConfig['password'];
        $dumpFileName = 'storage/app/public/db-backup-'.date('Ymd-His').'.sql';

        // Generate the mysqldump command
        $command = "mysqldump -u{$userName} {$databaseName} > {$dumpFileName}";
        // Execute the command
        shell_exec($command);
        dd($command);

        // Store the dump file in storage/app directory
        // $filePath = storage_path('app/' . $dumpFileName);
        // Storage::put($dumpFileName, file_get_contents($filePath));

        // Return the file as a download response
        $headers = [
            'Content-Type' => 'application/octet-stream',
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => 'attachment; filename=' . basename($filePath),
            'Content-Length' => filesize($filePath),
        ];

        return Response::download($filePath, basename($filePath), $headers);
    }

}
