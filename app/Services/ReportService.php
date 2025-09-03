<?php

namespace App\Services;

use App\Classes\PdfExporter;
use App\Classes\PdfGenerator;
use App\Contracts\ReportGenerator;


class ReportService
{

    function generateReport(ReportGenerator $generator, object $data)
    {
        return $generator->generate($data);
    }
}