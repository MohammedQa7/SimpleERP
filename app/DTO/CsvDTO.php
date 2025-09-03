<?php

namespace App\DTO;

class CsvDTO
{
    public string $file_name;
    public array $data;

    public function __construct(string $file_name, array $data)
    {
        $this->file_name = $file_name;
        $this->data = $data;
    }
}