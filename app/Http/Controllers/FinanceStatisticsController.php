<?php

namespace App\Http\Controllers;

use App\Services\InoviceSummary;
use App\Services\SalesSummary;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FinanceStatisticsController extends Controller
{

    protected $invoice_summary;
    protected $sales_summary;
    function __construct(InoviceSummary $inovice_summary, SalesSummary $sales_summary)
    {
        $this->invoice_summary = $inovice_summary;
        $this->sales_summary = $sales_summary;
    }

    public function __invoke(Request $request)
    {
        // dd($this->sales_summary->getCashFlowChart());

        return Inertia::render('FinanceDepartment/Statistics', [
            'salesSummary' => [
                $this->sales_summary->getRevenue(),
                $this->sales_summary->getProfit()
            ],
            'invoiceSummary' => [
                $this->invoice_summary->getPaidInvoices(),
                $this->invoice_summary->getPendingInvocies()
            ],

            'dailyCashFlow' => $this->sales_summary->getCashFlowChart(),
        ]);
    }
}