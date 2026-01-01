<?php

namespace App\Traits;

use Inertia\Inertia;

trait InertiaFlashMessage
{
    function success($message)
    {
        Inertia::flash([
            'message' => $message,
            'type' => 'success'
        ]);
    }


    function error($message)
    {
        Inertia::flash([
            'message' => $message,
            'type' => 'error'
        ]);
    }

}