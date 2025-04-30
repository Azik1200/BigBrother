<?php

namespace App\Exports;

use App\Models\Nld;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithMapping;

class NldExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        return Nld::with('group')
            ->when($this->request->filled('issue_key'), fn($q) => $q->where('issue_key', 'like', "%{$this->request->issue_key}%"))
            ->when($this->request->filled('reporter_name'), fn($q) => $q->where('reporter_name', 'like', "%{$this->request->reporter_name}%"))
            ->when($this->request->filled('issue_type'), fn($q) => $q->where('issue_type', $this->request->issue_type))
            ->when($this->request->filled('group_id'), function ($q) {
                if ($this->request->group_id === 'null') {
                    $q->whereNull('group_id');
                } else {
                    $q->where('group_id', $this->request->group_id);
                }
            })
            ->when($this->request->filled('done'), function ($q) {
                if ($this->request->done === '1') {
                    $q->whereNotNull('done_date');
                } elseif ($this->request->done === '0') {
                    $q->whereNull('done_date');
                }
            })
            ->when($this->request->filled('parent_issue_status'), fn($q) => $q->where('parent_issue_status', $this->request->parent_issue_status))
            ->get();
    }

    public function map($nld): array
    {
        return [
            $nld->id,
            $nld->issue_key,
            $nld->summary,
            $nld->description,
            $nld->reporter_name,
            $nld->issue_type,
            $nld->group->name ?? 'No group',
            $nld->control_status,
            $nld->parent_issue_key,
            $nld->parent_issue_status,
            $nld->parent_issue_number,
            $nld->updated,
            $nld->created,
            $nld->add_date,
            $nld->send_date,
            $nld->done_date,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Issue Key',
            'Summary',
            'Description',
            'Reporter',
            'Issue Type',
            'Group Name',
            'Control Status',
            'Parent Issue Key',
            'Parent Status',
            'Parent Number',
            'Updated Date',
            'Created Date',
            'Add Date',
            'Send Date',
            'Done Date',
        ];
    }
}
