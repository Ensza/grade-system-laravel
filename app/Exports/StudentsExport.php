<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsExport implements FromCollection, ShouldAutoSize, WithColumnWidths, WithStyles, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Student::all([
            'id',
            'name',
            'grade'
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle(1)->getFont()->setBold(true);
        $sheet->getStyle('A')->getAlignment()->setHorizontal('center');
    }

    public function headings(): array
    {
        return ['ID', 'NAME', 'GRADE'];
    }
}
