<?php

namespace App\DTO;

class CsvDTO
{
    public string $file_name;
    public array|null $data;
    public object|null $class_exporter_instance;

    public function __construct(string $file_name, array|null $data = null, object|null $class_exporter_instance)
    {
        $this->file_name = $file_name;
        $this->data = $data;
        $this->class_exporter_instance = $class_exporter_instance;
    }
}