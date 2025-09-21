<?php
namespace App\Handler\Exports;

use App\DTO\CsvDTO;
use App\DTO\PdfDTO;
use App\Exports\Hr\AttendanceLogsExport;
use App\Reports\Classes\CsvExporter;
use App\Reports\Classes\PdfExporter;
use App\Reports\Services\ExportReportService;
use Illuminate\Support\Facades\Log;

class ExportDispatcher
{
    function handle($module, $type)
    {
        $export_service = new ExportReportService();
        $export_module = ['attendance-logs' => new AttendanceLogsExport([...request()->query])];

        // Get the handler class name from the map
        if (isset($export_module[$module])) {
            return match ($type) {
                'csv' => $this->Csv($export_service, $export_module[$module]),
                'pdf' => $this->Pdf($export_service, $export_module[$module]),

                default => throw new \InvalidArgumentException("Invalid export type: {$type}", 400),
            };
        } else {
            throw new \InvalidArgumentException("Invalid export module: {$module}", 400);
        }
    }

    protected function Csv($export_service, $export_module)
    {
        Log::info('Preparing Data to process and export the CSV file');
        $csv_data = new CsvDTO(file_name: 'attendances logs', data: null, class_exporter_instance: $export_module);
        return $export_service->export(new CsvExporter(), $csv_data);
    }

    protected function Pdf($export_service, $export_module)
    {
        Log::info('Preparing Data to process and export the PDF file');
        $pdf_data = new PdfDTO(view: 'Receipts.test', data: $export_module->collection()->toArray());
        return $export_service->export(new PdfExporter(), $pdf_data);
    }

}