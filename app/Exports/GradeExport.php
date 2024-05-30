<?php

namespace App\Exports;

use App\Models\Grade;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GradeExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithColumnWidths, WithStyles
{
    public $subject_id;

    function __construct($subject_id) {
        $this->subject_id = $subject_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Grade::where('subject_id', $this->subject_id)->get();
    }

    public function map($grade): array
    {
        return [
            $grade->id,
            $grade->student->name,
            $grade->grade
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'NAME',
            'GRADE'
        ];
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
}
