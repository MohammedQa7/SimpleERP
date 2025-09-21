<?php

namespace App\Http\Controllers\Website;

use Illuminate\Routing\Controller;
use Inertia\Inertia;


class IndexController extends Controller
{
    function __invoke()
    {
        return Inertia::render('Website/Index');
    }
}