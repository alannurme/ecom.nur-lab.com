<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class BackupController extends Controller
{
    public function index()
    {
        $backupDir = storage_path('app/backups');
        if (!file_exists($backupDir)) {
            mkdir($backupDir, 0777, true);
        }

        $files = glob($backupDir . '/*.sql');
        $backups = [];
        foreach ($files as $file) {
            $backups[] = [
                'name' => basename($file),
                'size' => round(filesize($file) / 1024 / 1024, 2) . ' MB',
                'date' => date('Y-m-d H:i:s', filemtime($file)),
                'path' => $file
            ];
        }

        usort($backups, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        return view('backend.system.backups', compact('backups'));
    }

    public function create()
    {
        try {
            $backupDir = storage_path('app/backups');
            if (!file_exists($backupDir)) {
                mkdir($backupDir, 0777, true);
            }

            $filename = 'backup-' . date('Y-m-d-H-i-s') . '.sql';
            $filepath = $backupDir . '/' . $filename;

            $this->phpBackupDatabase($filepath);
            flash(translate('Database backup created successfully.'))->success();
        } catch (\Exception $e) {
            flash($e->getMessage())->error();
        }

        return back();
    }

    public function download($file_name)
    {
        $filepath = storage_path('app/backups/' . $file_name);
        if (file_exists($filepath)) {
            return response()->download($filepath);
        }
        flash(translate('File not found.'))->error();
        return back();
    }

    public function destroy($file_name)
    {
        $filepath = storage_path('app/backups/' . $file_name);
        if (file_exists($filepath)) {
            unlink($filepath);
            flash(translate('Backup file deleted successfully.'))->success();
        }
        return back();
    }

    private function phpBackupDatabase($filepath)
    {
        $tables = DB::select('SHOW TABLES');
        $dbName = env('DB_DATABASE');
        $prop = 'Tables_in_' . $dbName;
        
        $sql = "-- Active eCommerce Database Backup\n-- Date: " . date('Y-m-d H:i:s') . "\n\nSET FOREIGN_KEY_CHECKS=0;\n";
        
        foreach ($tables as $tableObj) {
            if (!isset($tableObj->$prop)) {
                $vars = get_object_vars($tableObj);
                $table = reset($vars);
            } else {
                $table = $tableObj->$prop;
            }

            $createTable = DB::select("SHOW CREATE TABLE `{$table}`");
            $createSqlKey = 'Create Table';
            $sql .= "\n\nDROP TABLE IF EXISTS `{$table}`;\n";
            $sql .= $createTable[0]->$createSqlKey . ";\n\n";
            
            $rows = DB::table($table)->get();
            foreach ($rows as $row) {
                $rowArray = (array)$row;
                $keys = array_keys($rowArray);
                $values = array_values($rowArray);
                
                $escapedValues = array_map(function($val) {
                    if (is_null($val)) return 'NULL';
                    return "'" . addslashes($val) . "'";
                }, $values);
                
                $sql .= "INSERT INTO `{$table}` (`" . implode("`, `", $keys) . "`) VALUES (" . implode(", ", $escapedValues) . ");\n";
            }
        }
        $sql .= "\nSET FOREIGN_KEY_CHECKS=1;\n";
        file_put_contents($filepath, $sql);
    }
}
