<?php
namespace App\Actions;

use App\Models\Product;

class AssignRoleToUser
{
    function handle($user, $roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                $user->assignRole($role);
            }
        }
    }
}