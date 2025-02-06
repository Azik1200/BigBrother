<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Procedure;
use Illuminate\Http\Request;
use App\Http\Controllers\FileController;

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
            'name' => 'required|string|max:255',
            'file' => 'required',
            'group_id' => 'required|exists:groups,id',
        ]);

        $fileController = new FileController();
        $uploadResponse = $fileController->upload($request);

        $uploadData = $uploadResponse->getData();

        if ($uploadData->success) {
            $filePath = $uploadData->file_path;

            Procedure::create([
                'name' => $validated['name'],
                'file_path' => $filePath,
                'group_id' => $validated['group_id'],
            ]);

            return redirect()->route('procedures')->with('success', 'Процедура успешно добавлена!');
        }

        return redirect()->back()->with('error', 'Не удалось загрузить файл. Попробуйте ещё раз.');
    }
}
