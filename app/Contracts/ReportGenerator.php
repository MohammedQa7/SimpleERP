<?php

namespace App\Contracts;

interface ReportGenerator
{
    public function generate(object $data);
}