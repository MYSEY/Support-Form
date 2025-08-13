<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class BackupController extends Controller
{
    public function databaseBackup()
    {
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host     = env('DB_HOST');

        $fileName = $database . '_backup_' . date('Y-m-d') . '.sql';
        $filePath = storage_path($fileName);

        // Run mysqldump (Linux & Windows friendly)
        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s > %s',
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($host),
            escapeshellarg($database),
            escapeshellarg($filePath)
        );

        exec($command);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
    public function filesBackup()
    {
        $zipFileName = 'storage-backup_'. date('Y-m-d') . '.zip';
        $zip = new ZipArchive;

        $zipPath = public_path($zipFileName);

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $folderPath = public_path('storage');
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($folderPath),
                RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $name => $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($folderPath) + 1);
                    $zip->addFile($filePath, $relativePath);
                }
            }

            $zip->close();
        }
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
    public function fullBackup()
    {
        $zipFileName = 'full-support-form-backup-' . date('Y-m-d') . '.zip';
        $zipPath = storage_path($zipFileName);

        $zip = new \ZipArchive;
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {

            // 1️⃣ Dump Database
            $database = env('DB_DATABASE');
            $username = env('DB_USERNAME');
            $password = env('DB_PASSWORD');
            $host     = env('DB_HOST');

            $sqlPath = storage_path('db_backup.sql');
            $command = sprintf(
                'mysqldump --user=%s --password=%s --host=%s %s > %s',
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($host),
                escapeshellarg($database),
                escapeshellarg($sqlPath)
            );
            exec($command);

            // Add DB file to zip
            if (file_exists($sqlPath)) {
                $zip->addFile($sqlPath, 'database_backup.sql');
            }

            // 2️⃣ Add Uploaded Files
            $folderPath = public_path('storage'); // ✅ Fixed path
            if (is_dir($folderPath)) {
                $files = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($folderPath),
                    \RecursiveIteratorIterator::LEAVES_ONLY
                );

                foreach ($files as $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        $relativePath = 'storage/' . substr($filePath, strlen($folderPath) + 1);
                        $zip->addFile($filePath, $relativePath);
                    }
                }
            }

            $zip->close();

            // Cleanup temp DB file
            if (file_exists($sqlPath)) {
                unlink($sqlPath);
            }
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }


    public function index()
    {
        return view('backups.index');
    }
}
