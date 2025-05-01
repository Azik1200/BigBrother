<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BackUpController extends Controller
{
    public function index()
    {
        $files = collect(Storage::files('backups'))
            ->map(function ($file) {
                return [
                    'name' => basename($file),
                    'size' => Storage::size($file),
                    'created' => Storage::lastModified($file),
                ];
            })->sortByDesc('created');

        return view('admin.backups.index', compact('files'));
    }

    public function download($filename)
    {
        $path = "backups/{$filename}";
        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return Storage::disk('local')->download($path);
    }

    public function create()
    {
        $db = config('database.connections.mysql');

        $username = $db['username'];
        $password = $db['password'];
        $database = $db['database'];
        $dumpPath = config('backup.dump_path');
        $backupPath = storage_path('app/backups/backup_' . now()->format('Y_m_d_His') . '.sql');

        // Формируем команду
        $command = "\"$dumpPath\" -u $username " .
            ($password ? "-p$password " : '') .
            "$database > \"$backupPath\"";

        exec($command . ' 2>&1', $output, $result);

        if ($result !== 0) {
            return response()->json([
                'error' => 'Backup failed',
                'output' => $output
            ], 500);
        }

        return redirect(route('admin.backups.index'))->with('success', 'Backup created successfully');
    }
}
