<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Nld;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

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
            'nld_file' => 'required|file|mimes:xlsx,xls|max:2048',
        ]);

        if ($request->hasFile('nld_file')) {
            $file = $request->file('nld_file');

            try {
                $excelData = Excel::toArray(new class() implements \Maatwebsite\Excel\Concerns\ToArray {
                    public function array(array $rows)
                    {
                        return $rows;
                    }
                }, $file);

                $rows = $excelData[0];

                if (count($rows) <= 1) {
                    return back()->with('error', 'Excel файл не содержит данных.');
                }

                foreach (array_slice($rows, 1) as $row) {
                    $nldData = [
                        'issue_key' => $row[0] ?? null,
                        'group_id' => null,
                        'summary' => $row[2] ?? '',
                        'description' => $row[3] ?? '-',
                        'reporter_name' => $row[4] ?? '',
                        'issue_type' => $row[5] ?? '',
                        'updated' => now()->format('Y-m-d'),
                        'created' => now()->format('Y-m-d'),
                        'parent_issue_key' => $row[8] ?? '',
                        'parent_issue_status' => $row[9] ?? '',
                        'parent_issue_number' => $row[10] ?? '',
                        'control_status' => 'To Do',
                        'add_date' => now()->format('Y-m-d'),
                        'send_date' => now()->format('Y-m-d'),
                        'done_date' => null,
                    ];

                    try {
                        Nld::create($nldData);
                    } catch (\Exception $e) {
                        dd('Ошибка при сохранении:', $e->getMessage(), $nldData);
                    }
                }


                return redirect()->route('nld')->with('success', 'Данные из Excel успешно импортированы.');

            } catch (\Exception $e) {
                return back()->with('error', 'Ошибка при обработке Excel: ' . $e->getMessage());
            }
        }

        return back()->with('error', 'Файл не загружен.');
    }


    public function show(Nld $nld)
    {
        $comments = $nld->comments;

        return view('nld.nld', compact('nld', 'comments'));
    }

    public function edit(Nld $nld)
    {
        $groups = Group::select('id', 'name')->get(); // получаем id и название всех групп

        return view('nld.edit', compact('nld', 'groups'));
    }


    public function update(Request $request, Nld $nld)
    {
        $request->validate([
            'group_id' => 'nullable|integer',
        ]);

        $nld->update(['group_id' => $request->input('group_id'),
                        'send_date' => now()->format('Y-m-d')]);

        return redirect()->route('nld')->with('success', 'Группа NLD успешно обновлена.');
    }

    public function destroy(Nld $nld)
    {
        $nld->delete();
        return redirect()->route('nlds.index')->with('success', 'NLD запись успешно удалена.');
    }

    public function done(Nld $nld)
    {
        $nld->update(['done_date' => now()->format('Y-m-d'),
            'group_id' => null]);

        return redirect()->route('nld');
    }
}
