<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

class AttendeesExport implements FromCollection, WithMapping, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function map($row): array {
        // dd($row->toArray());
        static $rowNumber = 0;

        $rowNumber++;

        return [
            $rowNumber,
            $row->name,
            $row->age,
            $row->gender,
            $row->phone_number,
            $row->nrc_number,
            $row->edu_background,
            $row->department,
            $row->position,
            $row->address,
            $row->email,
            !empty($row->attendees_types) ? $row->attendees_types->name : '-',
            $row->created_at,
            $row->updated_at,
        ];
    }

    public function headings(): array {
        return [
            'No',
            'Name',
            'Age',
            'Gender',
            'Phone number',
            'NRC number',
            'Eduction background',
            'Department',
            'Position',
            'Address',
            'Email',
            'Attendees types',
            'Created_at',
            'Updated_at',
        ];
    }

    public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet) {
        return [
            1 => ['font' => ['bold' => true]]
        ];
    }
}
