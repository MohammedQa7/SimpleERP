<?php

namespace App\Reports\Contracts;
interface ReportExport
{
    public function export(object $data);
}