<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AttendeesImport implements ToModel, WithHeadingRow
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
            'age' => $row['age'],
            'sex' => $row['sex'],
            'phone_number' => $row['phone_number'],
            'nrc_number' => $row['nrc_number'],
            'edu_background' => $row['edu_background'],
            'position' => $row['position'],
            'department' => $row['department'],
            'address' => $row['address'],
            'email' => $row['email'],
        ]);
    }
}
