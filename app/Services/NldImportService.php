<?php

namespace App\Services;

use App\Models\Nld;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Facades\Excel;

class NldImportService
{
    /**
     * Import NLD entries from an Excel file.
     *
     * @param UploadedFile $file
     * @throws \Exception
     */
    public function importFromFile(UploadedFile $file): void
    {
        $excelData = Excel::toArray(new class implements ToArray {
            public function array(array $rows)
            {
                return $rows;
            }
        }, $file);

        $rows = $excelData[0] ?? [];

        if (count($rows) <= 1) {
            throw new \Exception('Excel файл не содержит данных.');
        }

        foreach (array_slice($rows, 1) as $row) {
            $nldData = $this->mapRowToNldData($row);

            try {
                Nld::create($nldData);
            } catch (\Exception $e) {
                Log::error('Ошибка сохранения NLD: ' . $e->getMessage(), $nldData);
                throw new \Exception('Ошибка при сохранении данных.');
            }
        }
    }

    private function mapRowToNldData(array $row): array
    {
        $baseDate = Carbon::createFromDate(1900, 1, 1);

        $createdDate = is_numeric($row[6] ?? null)
            ? $baseDate->copy()->addDays($row[6] - 2)->format('Y-m-d')
            : now()->format('Y-m-d');

        $updatedDate = is_numeric($row[5] ?? null)
            ? $baseDate->copy()->addDays($row[5] - 2)->format('Y-m-d')
            : now()->format('Y-m-d');

        return [
            'issue_key' => $row[0] ?? null,
            'summary' => isset($row[1]) ? str_replace('_x000D_', "\n", $row[1]) : '',
            'description' => isset($row[2]) ? str_replace('_x000D_', "\n", $row[2]) : '-',
            'reporter_name' => $row[3] ?? '',
            'issue_type' => $row[4] ?? '',
            'updated' => $updatedDate,
            'created' => $createdDate,
            'parent_issue_key' => $row[7] ?? '',
            'parent_issue_status' => isset($row[8]) ? str_replace('_x000D_', "\n", $row[8]) : '',
            'parent_issue_number' => $row[9] ?? '',
            'control_status' => 'To Do',
            'add_date' => now()->format('Y-m-d'),
            'send_date' => null,
        ];
    }
}
