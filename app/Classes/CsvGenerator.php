<?php

namespace App\Classes;

use App\Contracts\ReportGenerator;
use Illuminate\Support\Collection;


class CsvGenerator implements ReportGenerator
{
    function generate(object $data)
    {
        dd($data, 'csv');
        return 'CSV';
    }
}