<?php

use Illuminate\Support\Facades\Broadcast;
use LDAP\ResultEntry;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});



Broadcast::channel('tenant-setup', function () {
    return true;
});