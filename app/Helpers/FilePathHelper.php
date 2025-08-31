<?php

namespace App\Helpers;

use App\Enums\FileAndFolderGlobalPaths;
use App\Models\Attendance;

class FilePathHelper
{
    public static function build(FileAndFolderGlobalPaths $base_path, array $segemnts)
    {
        return $base_path->value . implode('/', $segemnts) . '/';
    }


    public static function buildCustomerUploadPath(FileAndFolderGlobalPaths $base_path, array $segemnts, $customer_code)
    {
        return "customers/{$customer_code}/" . $base_path->value . implode('/', []) . '/';
    }
}