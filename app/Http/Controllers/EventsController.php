<?php

namespace App\Http\Controllers;

use App\Actions\AttachUsersToEvent;
use App\Enums\Priorities;
use App\Helpers\GlobalHelpers;
use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Http\Resources\UserResource;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;

class EventsController extends Controller
{
    function index()
    {
        $events = Event::with(
            'user',
            'invitedUsers'
        )->get();

        return Inertia::render('HrDepartment/EventsCalendar', [
            'events' => EventResource::collection($events),
        ]);
    }

    function create(Request $request)
    {

        $users = User::employeesOnly()->get();

        $custom_user_resource = $users->map(function ($item) {
            return [
                'label' => $item->name,
                'value' => $item->employee_code,
            ];
        });

        $priorities = Priorities::toArray();

        if ($request->ajax()) {
            return response()->json([
                'users' => $custom_user_resource,
                'priorities' => $priorities,
            ]);
        }

        // Inertia response

    }

    function store(EventRequest $request, AttachUsersToEvent $action)
    {

        try {
            DB::beginTransaction();

            $event = Event::create([
                'uuid' => Str::uuid(),
                'user_id' => auth()->id(),
                'title' => $request->title,
                'description' => $request->description,
                'start_date' => $request->startDate,
                'starts_at' => $request->startsAt,
                'ends_at' => $request->endsAt,
                'priority' => $request->priority,
                'status' => 'Waiting',
            ]);

            // attaching invited memebers to the created event
            $action->handle($event, $request->attendances);



            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

    }

    function edit(Event $event)
    {

    }


    function update(Event $event)
    {

    }
}