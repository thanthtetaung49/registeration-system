<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

class RegisterAttendeesCheckInStatusExport implements FromCollection, WithMapping, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function map($row): array
    {
        static $rowNumber = 0;

        $rowNumber++;

        return [
            $rowNumber,
            $row->events->event_name,
            $row->register_attendees->name,
            !empty($row->attendees_types) ? $row->attendees_types->name : '-',
            !empty($row->scan_time) ? $row->scan_time : '-',
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Event name',
            'Attendees name',
            'Attendees types',
            'Check in time'
        ];
    }

    public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]]
        ];
    }
}
