<?php
namespace App\Actions;

use App\Models\DepartmentNotificaion;
use App\Models\Product;
use Illuminate\Support\Str;

class NotifyDepartment
{
    public function handle(string $from_department, string $to_department, string $message)
    {
        DepartmentNotificaion::create([
            'id' => Str::uuid(),
            'from_department' => $from_department,
            'to_department' => $to_department,
            'data' => [
                'message' => $message
            ],
        ]);
    }
}