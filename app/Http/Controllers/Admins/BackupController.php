<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class BackupController extends Controller
{
    public function index()
    {
        return view('backups.index');
    }
    public function databaseBackup()
    {
        $mysqldumpPath = env('MYSQLDUMP_PATH');
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host     = env('DB_HOST');
        $port     = env('DB_PORT');
    
        $fileName = $database . '_backup_' . date('Y-m-d') . '.sql';
        $filePath = storage_path("app/{$fileName}");
    
        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0777, true);
        }
    
        // Use --password=... without quotes (Windows-friendly)
        $passwordPart = $password !== '' ? "--password={$password}" : '';
        
        // Add port if not default
        $portPart = $port != 3306 ? "-P{$port}" : '';
    
        // Build command
        $command = sprintf(
            'cmd /c ""%s" -u%s %s %s -h%s %s > "%s" 2>&1"',
            $mysqldumpPath,
            $username,
            $passwordPart,
            $portPart,
            $host,
            $database,
            $filePath
        );
    
        $output = [];
        $returnVar = null;
        exec($command, $output, $returnVar);
    
        // Logging
        // Log::info('Backup command:', [$command]);
        // Log::info('Backup output:', $output);
        // Log::info('Backup return code:', ['code' => $returnVar]);
    
        if ($returnVar !== 0) {
            return response()->json([
                'error' => 'Backup failed',
                'output' => implode("\n", $output)
            ], 500);
        }
    
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
        $zipFileName = 'full-backup-' . date('Y-m-d') . '.zip';
        $zipPath = storage_path($zipFileName);

        $zip = new \ZipArchive;
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {

            // 1️⃣ Dump Database
            $database = env('DB_DATABASE');
            $username = env('DB_USERNAME');
            $password = env('DB_PASSWORD');
            $host     = env('DB_HOST');
            $port     = env('DB_PORT', 3306); // default 3306
            $mysqldumpPath = env('MYSQLDUMP_PATH', 'mysqldump'); // optional from .env

            $sqlPath = storage_path('db_backup.sql');

            // ✅ safer command
            $command = sprintf(
                '"%s" --user=%s --password=%s --host=%s --port=%d %s > "%s"',
                $mysqldumpPath,
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($host),
                $port,
                escapeshellarg($database),
                $sqlPath
            );

            // Run and capture output/errors
            exec($command . ' 2>&1', $output, $returnVar);
            if ($returnVar !== 0) {
                Log::error('Database backup failed', [
                    'command' => $command,
                    'output'  => $output
                ]);
                throw new \Exception("Database backup failed: " . implode("\n", $output));
            }

            // Add DB file to zip
            if (file_exists($sqlPath) && filesize($sqlPath) > 0) {
                $zip->addFile($sqlPath, 'database_backup.sql');
            } else {
                throw new \Exception("Database dump file is empty!");
            }

            // 2️⃣ Add Uploaded Files
            $folderPath = public_path('uploads');
            if (is_dir($folderPath)) {
                $files = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($folderPath),
                    \RecursiveIteratorIterator::LEAVES_ONLY
                );

                foreach ($files as $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        $relativePath = 'uploads/' . substr($filePath, strlen($folderPath) + 1);
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

    public function restoreDatabase(Request $request)
    {
        set_time_limit(600);
        ini_set('memory_limit', '512M');

        $startTime = microtime(true);

        // Use mysql.exe for restoring
        $mysqlPath = env('MYSQLDUMP_PATH');
        $username  = env('DB_USERNAME', 'root');
        $password  = env('DB_PASSWORD', '');
        $host      = env('DB_HOST', '127.0.0.1');
        $database  = env('DB_DATABASE', 'db_hr_test');

        $file = $request->file('sql_file');
        $tempDir = 'C:\\tmp';
        if (!file_exists($tempDir)) mkdir($tempDir, 0777, true);

        $tempPath = $tempDir . '\\' . $file->getClientOriginalName();
        $file->move($tempDir, $file->getClientOriginalName());

        $escapedPassword = str_replace(['^', '&', '<', '>', '|'], ['^^', '^&', '^<', '^>', '^|'], $password);
        $passwordPart = $password !== '' ? "-p{$escapedPassword}" : '';

        $command = sprintf(
            'cmd /c ""%s" -u%s %s -h%s %s < "%s" 2>&1"',
            $mysqlPath,
            $username,
            $passwordPart,
            $host,
            $database,
            $tempPath
        );

        $output = [];
        $returnVar = null;
        exec($command, $output, $returnVar);

        //**  for log issue code */
        // Log::info('Restore command:', [$command]);
        // Log::info('Database restore output:', $output);
        // Log::info('Database restore return code:', ['code' => $returnVar]);

        if ($returnVar !== 0) {
            return back()->with('error', 'Restore failed. Output: ' . implode("\n", $output));
        }

        $restoreTime = round(microtime(true) - $startTime, 2);
        return back()->with('success', "Database restored successfully in {$restoreTime} seconds!");
    }

    public function restoreFiles(Request $request)
    {
        $startTime = microtime(true); // Start timer
        
        // Validate ZIP upload
        // $request->validate([
        //     'zip_file' => 'required|mimes:zip|max:51200' // 50MB limit
        // ]);
        $zip = new \ZipArchive;
        $zipPath = $request->file('zip_file')->getRealPath();

        $extractPath = storage_path('app/uploads_restore');
        
        // Create folder if not exists
        if (!file_exists($extractPath)) {
            mkdir($extractPath, 0755, true);
        }

        if ($zip->open($zipPath) === TRUE) {

            // 🧹 Optional: clean old restore folder before extraction
            File::cleanDirectory($extractPath);

            // Extract ZIP
            $zip->extractTo($extractPath);
            $zip->close();

            $endTime = microtime(true); // End timer after extraction
            $restoreTime = round($endTime - $startTime, 2);

            Log::info("Files restored to {$extractPath} in {$restoreTime} seconds.");

            return back()->with('success', "Files restored successfully in {$restoreTime} seconds.");
        } else {
            Log::error("Failed to open ZIP: {$zipPath}");
            return back()->with('error', 'Failed to open ZIP file.');
        }
    }

}
