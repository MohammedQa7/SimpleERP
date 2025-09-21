<?php

namespace App\Reports\Contracts;

interface ReportGenerator
{
    public function generate(object $data);
}