<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $validated = $request->validate([
            'file' => ['required', 'file'],
        ]);

        $file = $validated['file'];

        $filePath = $file->store('admin/files', 'public');

        return response()->json([
            'success' => true,
            'file_path' => $filePath,
            'url' => asset('storage/' . $filePath),
        ]);
    }

    public function delete(Request $request)
    {
        $validated = $request->validate([
            'file_path' => ['required', 'string'],
        ]);

        $filePath = $validated['file_path'];

        if (!Storage::disk('public')->exists($filePath)) {
            return response()->json([
                'success' => false,
                'message' => 'Файл не найден',
            ], 404);
        }

        Storage::disk('public')->delete($filePath);

        return response()->json([
            'success' => true,
            'message' => 'Файл успешно удалён',
        ]);
    }
}
