<?php

namespace App\Reports\Services;

use App\Reports\Contracts\ReportExport;



class ExportReportService
{
    function export(ReportExport $report_export, $data)
    {
        return $report_export->export($data);
    }
}