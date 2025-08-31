<?php

namespace App\Services;

use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\Models\Order;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Whoops\Util\HtmlDumperOutput;

class SalesSummary
{

    protected $invoice;
    protected $orders;

    function __construct()
    {
        $this->orders = Order::with('invoice', 'orderItems.product')
            ->whereHas(
                'invoice',
                function ($invoice) {
                    $invoice->where('status', InvoiceStatus::PAID->value);
                }
            )->get();
    }

    function getRevenue()
    {
        $total_revenue = $this->orders->sum('total_price');


        $total_revenue_current_month = $this->orders->where(function ($query) {
            if ($query->invoice->status->value == InvoiceStatus::PAID->value) {
                return $query->invoice->updated_at->isSameMonth(now());
            }
        })->sum('total_price');

        $total_revenue_last_month = $this->orders->where(function ($query) {
            if ($query->invoice->status->value == InvoiceStatus::PAID->value) {
                return $query->invoice->updated_at->isSameMonth(now()->subMonth());
            }
        })->sum('total_price');



        return [
            'title' => 'Total Revenue',
            'value' => $total_revenue,
            'icon' => 'BarChart',
            'color' => 'emerald',
            'percentage' => $total_revenue_last_month > 0
            ? round((($total_revenue_current_month - $total_revenue_last_month) / $total_revenue_last_month) * 100, 2)
            : 0
        ];
    }

    function getProfit()
    {
        $total_profit = 0;
        foreach ($this->orders as $order) {
            foreach ($order->orderItems as $item) {
                $total_profit += ($item->product->selling_price - $item->product->cost_price) * $item->quantity;
            }
        }

        return [
            'title' => 'Total Profit',
            'value' => $total_profit,
            'icon' => 'Clock',
            'color' => 'amber',
        ];
    }


    function getCashFlowChart()
    {
        $week_days = [];
        $daily_period = CarbonPeriod::create(now()->startOfWeek(), '1 day', now()->endOfWeek());
        // pushing all the days into the array.
        foreach ($daily_period as $day) {
            $week_days[$day->format('D')] = [
                'day' => $day->format('D'),
                'cash' => 0
            ];
        }

        // Getting all orders grouped by their date which is formated to the DAY.
        $cash_flow_per_day = $this->orders
            ->filter(function ($order) {
                return $order->updated_at->isSameWeek(now());
            })
            ->groupBy(function ($order) {
                return $order->updated_at->format('D');
            });


        // looping to get the total price for each day and fomart them in a array that consist of the day and the value.
        foreach ($cash_flow_per_day as $key_as_day => $value) {
            foreach ($value as $index => $order) {
                $week_days[$key_as_day]['cash'] += $order->total_price;
            }
        }


        return array_values($week_days);
    }

}