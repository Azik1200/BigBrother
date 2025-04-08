<?php

namespace App\Http\Controllers;

use App\Models\Nld;
use Illuminate\Http\Request;

class NldController extends Controller
{
    public function index()
    {
        $nlds = Nld::all();
        return view('nld.index', compact('nlds'));
    }

    public function create()
    {
        return view('nld.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'group_id' => 'nullable|integer',
            'reporter_name' => 'required|string|max:255',
            'issue_type' => 'required|string|max:255',
            'updated' => 'required|date',
            'created' => 'required|date',
            'parent_issue_key' => 'nullable|string|max:255',
            'parent_issue_status' => 'nullable|string|max:255',
            'parent_issue_number' => 'nullable|string|max:255',
            'control_status' => 'nullable|string|max:255',
            'add_date' => 'required|date',
            'send_date' => 'nullable|date',
            'done_date' => 'nullable|date',
        ]);

        Nld::create($request->all());

        return redirect()->route('nlds.index')->with('success', 'NLD запись успешно создана.');
    }

    public function show(Nld $nld)
    {
        return view('nlds.show', compact('nld'));
    }

    public function edit(Nld $nld)
    {
        return view('nlds.edit', compact('nld'));
    }

    public function update(Request $request, Nld $nld)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'group_id' => 'nullable|integer',
            'reporter_name' => 'required|string|max:255',
            'issue_type' => 'required|string|max:255',
            'updated' => 'required|date',
            'created' => 'required|date',
            'parent_issue_key' => 'nullable|string|max:255',
            'parent_issue_status' => 'nullable|string|max:255',
            'parent_issue_number' => 'nullable|string|max:255',
            'control_status' => 'nullable|string|max:255',
            'add_date' => 'required|date',
            'send_date' => 'nullable|date',
            'done_date' => 'nullable|date',
        ]);

        $nld->update($request->all());

        return redirect()->route('nlds.index')->with('success', 'NLD запись успешно обновлена.');
    }

    public function destroy(Nld $nld)
    {
        $nld->delete();
        return redirect()->route('nlds.index')->with('success', 'NLD запись успешно удалена.');
    }
}
