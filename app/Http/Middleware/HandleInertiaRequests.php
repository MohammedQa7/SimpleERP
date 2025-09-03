<?php

namespace App\Http\Middleware;

use App\Http\Resources\AnnouncementsResource;
use App\Http\Resources\AttendanceLogResource;
use App\Models\Announcement;
use App\Models\AttendanceLog;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        [$message, $author] = str(Inspiring::quotes()->random())->explode('-');

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'quote' => ['message' => trim($message), 'author' => trim($author)],
            'auth' => [
                'user' => $request->user(),
            ],
            // Below code need to be modifide for preformance issues in the future.
            'announcements' => AnnouncementsResource::collection(Announcement::latest()->limit(3)->get()),
            'lastAnnouncement' => Announcement::latest()->first()->uuid ?? null,
            'isEmployeeCheckedIn' => auth()->check() ? AttendanceLog::isEmployeeCheckedIn() : null,
            // --------
            'ziggy' => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'csrf' => csrf_token(),
        ];

    }
}