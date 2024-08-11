<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AttendeesImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);

        return new User([
            'name' => $row['name'],
            'age' => $row['age'] ? $row['age'] : null,
            'sex' => $row['sex'],
            'phone_number' => $row['phone_number'],
            'nrc_number' => $row['nrc_number'] ?? $row['nrc_number'],
            'edu_background' => $row['edu_background'],
            'position' => $row['position'],
            'department' => $row['department'] ?? $row['department'],
            'address' => $row['address'],
            'email' => $row['email'],
            'attendees_types_id' => $row['attendees_types_id'] ?? $row['attendees_types_id'],
            'is_admin' => $row['is_admin'] ? $row['is_admin'] : 0,
            'attendees_groups_id' => $row['attendees_groups_id'] ?? $row['attendees_groups_id']
        ]);
    }
}
