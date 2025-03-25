<?php

namespace App\Http\Controllers;

use App\Actions\AssignRoleToUser;
use App\Enums\JobTitles;
use App\Enums\OrderStatus;
use App\Enums\UserRoles;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    function index()
    {
        $roles = Role::get();
        $users = User::get();
        return Inertia::render('UserManagement/index', [
            'users' => UserResource::collection($users),
            'roles' => RoleResource::collection($roles),
            'jobTitles' => JobTitles::toArray(),
        ]);
    }

    function store(UserRequest $request, AssignRoleToUser $action)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phoneNumber,
                'employee_code' => 'EMP-' . rand(0, 100000),
                'job_title' => $request->jobTitle,
                'address' => $request->address,
                'salary' => $request->salary,
                'joined_at' => now(),
            ]);

            $action->handle($user, $request->roles);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    function edit(User $user)
    {
        return Inertia::render('UserManagement/index', [
            'user' => new UserResource($user),
        ]);
    }

    function update(UserUpdateRequest $request, User $user)
    {
        // Build an array of updatable fields
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phoneNumber,
            'job_title' => $request->jobTitle,
            'address' => $request->address,
            'salary' => $request->salary,
        ];

        // Only update the password if it's provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
    }
}