<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

class BackupController extends Controller
{
    // === SHOW BACKUP + MAINTENANCE PAGE ===
    public function index()
    {
        $backups = Storage::files('public/backups');

        // Maintenance metrics
        $storageUsed = $this->getStorageUsage();
        $dbStatus = $this->checkDbStatus();
        $systemInfo = $this->getSystemInfo();

        return view('admin.backup.index', compact('backups', 'storageUsed', 'dbStatus', 'systemInfo'));
    }


    // ================================================
    // 🔥 BACKUP ACTIONS
    // ================================================

    public function runBackup()
    {
        if(!Storage::exists('public/backups')){
            Storage::makeDirectory('public/backups');
        }

        $tables = DB::select('SHOW TABLES');
        $sql = '';

        foreach ($tables as $tableObj) {

            // FIXED table name extraction
            $table = array_values((array)$tableObj)[0];

            // FIXED safe CREATE TABLE extraction
            $createRow = (array) DB::select("SHOW CREATE TABLE `$table`")[0];
            $create = $createRow['Create Table'] ?? reset($createRow);

            $sql .= $create . ";\n\n";

            // INSERT ROWS
            $rows = DB::table($table)->get();
            foreach ($rows as $row) {
                $columns = implode('`,`', array_keys((array)$row));
                $values = implode("','", array_map(function($v){
                    return addslashes($v);
                }, array_values((array)$row)));

                $sql .= "INSERT INTO `$table` (`$columns`) VALUES ('$values');\n";
            }

            $sql .= "\n\n";
        }

        $timestamp = now()->format('Y-m-d_H-i-s');
        $fileName = "backup_$timestamp.sql";

        Storage::put("public/backups/$fileName", $sql);

        return back()->with('success', "Backup created: $fileName");
    }


    // Delete all backups
    public function cleanOldBackups()
    {
        $files = Storage::files('public/backups');

        foreach ($files as $file) {
            Storage::delete($file);
        }

        return back()->with('success', 'All backups deleted!');
    }

    public function download($filename)
    {
        $path = "public/backups/$filename";

        if (!Storage::exists($path)) {
            return back()->with('error', 'Backup file not found.');
        }

        // Get file content
        $file = Storage::get($path);
        $mime = Storage::mimeType($path);

        // Delete after sending
        Storage::delete($path);

        return response($file, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }



    // ================================================
    // 🔧 MAINTENANCE ACTIONS
    // ================================================

    public function clearLogs()
    {
        $logFile = storage_path('logs/laravel.log');

        if (file_exists($logFile)) {
            file_put_contents($logFile, "");
        }

        return back()->with('success', 'System logs cleared successfully!');
    }

    public function clearCache()
    {
        Artisan::call("cache:clear");
        Artisan::call("route:clear");
        Artisan::call("view:clear");
        Artisan::call("config:clear");
        Artisan::call("clear-compiled");

        return back()->with('success', 'All system caches cleared successfully!');
    }

    public function optimize()
    {
        Artisan::call("optimize:clear");
        Artisan::call("view:cache");

        return back()->with('success', 'System optimized successfully!');
    }


    // AJAX: Check storage usage
    public function storageUsage()
    {
        return response()->json($this->getStorageUsage());
    }

    // AJAX: Check DB health
    public function dbHealth()
    {
        return response()->json($this->checkDbStatus());
    }


    // ================================================
    // 📊 MAINTENANCE HELPERS
    // ================================================

    private function getStorageUsage()
    {
        $size = 0;

        foreach (Storage::allFiles() as $file) {
            $size += Storage::size($file);
        }

        return [
            'total_mb' => round($size / 1024 / 1024, 2)
        ];
    }

    private function checkDbStatus()
    {
        try {
            DB::connection()->getPdo();
            return "Database is healthy ✔";
        } catch (\Exception $e) {
            return "Database error ❌";
        }
    }

    private function getSystemInfo()
    {
        return [
            'php' => phpversion(),
            'laravel' => app()->version(),
            'os' => PHP_OS,
            'upload_limit' => ini_get('upload_max_filesize'),
        ];
    }
}