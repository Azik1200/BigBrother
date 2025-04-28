<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Procedure;
use Illuminate\Http\Request;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Storage;

class ProcedureController extends Controller
{
    public function index()
    {
        $procedures = Procedure::all();
        $groups = Group::all();

        return view('admin.procedures.index', compact('procedures', 'groups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'file' => ['required', 'file'],
            'group_id' => ['required', 'exists:groups,id'],
        ]);

        if (!$request->hasFile('file')) {
            return redirect()->back()->with('error', 'Файл не найден.');
        }

        try {
            $file = $validated['file'];
            $filePath = $file->store('admin/files', 'public');

            Procedure::create([
                'name' => $validated['name'],
                'file_path' => $filePath,
                'group_id' => $validated['group_id'],
            ]);

            return redirect()->route('procedures')->with('success', 'Процедура успешно добавлена!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ошибка при загрузке файла: ' . $e->getMessage());
        }
    }
}
