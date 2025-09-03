<?php

namespace App\Classes;

use App\Contracts\ReportGenerator;
use Illuminate\Support\Collection;


class PdfGenerator implements ReportGenerator
{
    function generate(object $data)
    {
        $pdf = \PDF::loadView($data->view, $data->data);
        return $pdf->output();
    }
}