<?php

namespace App\Imports;

use App\Models\Schedule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ScheduleImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Schedule([
            'user_id'  => $row['user_id'],
            'date'     => $row['date'],
            'shift_id' => $row['shift_id'],
        ]);
    }
}
