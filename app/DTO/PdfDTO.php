<?php

namespace App\DTO;

class PdfDTO
{
    public string $view;
    public array $data;

    public function __construct(string $view, array $data)
    {
        $this->view = $view;
        $this->data = $data;
    }
}