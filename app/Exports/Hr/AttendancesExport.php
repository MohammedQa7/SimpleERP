<?php

namespace App\Exports\Hr;

use App\Models\Attendances;
use Maatwebsite\Excel\Concerns\FromCollection;

class AttendancesExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Attendances::all();
    }
}