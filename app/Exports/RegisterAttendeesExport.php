<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

class RegisterAttendeesExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $items;

    public function __construct($items) {
        $this->items = $items;
    }

    public function collection()
    {
        // dd($this->items->toArray());
        return collect($this->items);
    }

    public function map($user): array
    {
        $rows = [];

        foreach ($user->register_events as $index => $register_event) {
            $rows[] = [
                $user->phone_number,
                $user->email,
                $register_event->qr_code ?? '-',
                $register_event->events->event_name ?? 'null',
            ];
        }

        return $rows;
    }

    public function headings(): array {
        return [
            'Phone number',
            'Email',
            'Code',
            'Event name'
        ];
    }

    public function styles(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]]
        ];
    }
}
