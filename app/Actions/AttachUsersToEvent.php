<?php
namespace App\Actions;

use App\Models\Event;
use App\Models\Product;
use App\Models\User;

class AttachUsersToEvent
{
    function handle(Event $event, $users)
    {
        foreach ($users as $employee_code) {
            $user = User::where('employee_code', $employee_code)->firstOrFail();
            $event->invitedUsers()->attach($user->id);
        }
    }
}