<?php

namespace App\Http\Controllers;

use App\Http\Resources\ThemeResource;
use App\Models\Theme;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AppearanceController extends Controller
{
    function __invoke()
    {
        return Inertia::render('settings/Appearance', [
            'themes' => ThemeResource::collection(Theme::get()),
        ]);
    }
}