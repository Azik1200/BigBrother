<?php

namespace App\Exports;

use App\Models\Nld;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Auth;

class NldExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Nld::with(['groups', 'doneStatuses'])
            ->when($this->request->filled('issue_key'), fn ($q) =>
                $q->where('issue_key', 'like', "%{$this->request->issue_key}%"))
            ->when($this->request->filled('reporter_name'), fn ($q) =>
                $q->where('reporter_name', 'like', "%{$this->request->reporter_name}%"))
            ->when($this->request->filled('issue_type'), fn ($q) =>
                $q->where('issue_type', $this->request->issue_type))
            ->when($this->request->filled('group_id'), function ($q) {
                if ($this->request->group_id === 'null') {
                    $q->whereDoesntHave('groups');
                } else {
                    $q->whereHas('groups', fn ($query) =>
                        $query->where('groups.id', $this->request->group_id));
                }
            })
            ->when($this->request->filled('parent_issue_status'), function ($q) {
                $statuses = $this->request->input('parent_issue_status');
                $statuses = is_array($statuses) ? array_filter($statuses) : [$statuses];
                if (!empty($statuses)) {
                    $q->whereIn('parent_issue_status', $statuses);
                }
            });

        $user = Auth::user();
        if ($user && !$user->isAdmin()) {
            $userGroupIds = $user->groups->pluck('id');
            $query->whereHas('groups', fn($q) => $q->whereIn('groups.id', $userGroupIds));
        }

        $all = $query->get();

        if ($this->request->filled('done')) {
            $all = $all->filter(function ($nld) {
                $groupIds = $nld->groups->pluck('id')->sort()->values();
                $doneGroupIds = $nld->doneStatuses->pluck('group_id')->sort()->values();

                $isDone = $groupIds->count() > 0 && $groupIds->diff($doneGroupIds)->isEmpty() && $doneGroupIds->diff($groupIds)->isEmpty();

                return $this->request->done === '1' ? $isDone : !$isDone;
            });
        }

        return $all->values();
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
            $nld->groups->pluck('name')->join(', ') ?? 'No group',
            $nld->control_status,
            $nld->parent_issue_key,
            $nld->parent_issue_status,
            $nld->parent_issue_number,
            $nld->updated,
            $nld->created,
            $nld->add_date,
            $nld->send_date,
            $this->resolveDoneDate($nld),
        ];
    }

    private function resolveDoneDate($nld)
    {
        if ($nld->done_date) {
            return $nld->done_date;
        }

        $doneAt = $nld->doneStatuses->min('done_at');
        return $doneAt ? \Carbon\Carbon::parse($doneAt)->format('d.m.Y H:i') : null;
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
