<?php

namespace App\Reports\Classes;

use App\Reports\Contracts\ReportExport;
use Maatwebsite\Excel\Facades\Excel;


class CsvExporter implements ReportExport
{
    public function export(object $data)
    {
        return Excel::download($data->class_exporter_instance, $data->file_name . '.xlsx');
    }
}