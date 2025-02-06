<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required',
        ]);

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('admin/files', 'public');
            return response()->json([
                'success' => true,
                'file_path' => $filePath,
                'url' => asset('storage/' . $filePath),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Файл не найден или не загружен',
        ], 400);
    }

    public function delete(Request $request)
    {
        $validated = $request->validate([
            'file_path' => 'required|string',
        ]);

        $filePath = $validated['file_path'];

        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
            return response()->json([
                'success' => true,
                'message' => 'Файл успешно удалён',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Файл не найден',
        ], 404);
    }
}
