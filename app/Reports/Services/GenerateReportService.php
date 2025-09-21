<?php

namespace App\Reports\Services;

use App\Classes\PdfExporter;
use App\Classes\PdfGenerator;
use App\Reports\Contracts\ReportGenerator;


class GenerateReportService
{
    function generate(ReportGenerator $generator, object $data)
    {
        return $generator->generate($data);
    }
}