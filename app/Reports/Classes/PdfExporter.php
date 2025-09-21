<?php

namespace App\Reports\Classes;

use App\Reports\Contracts\ReportExport;


class PdfExporter implements ReportExport
{
    function export(object $data)
    {
        $pdf = \PDF::loadView($data->view, $data->data);
        return $pdf->download();
    }
}