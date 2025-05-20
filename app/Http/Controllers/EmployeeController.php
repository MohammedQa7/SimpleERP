<?php

namespace App\Http\Controllers;

use App\Actions\AssignRoleToUser;
use App\Enums\Departments;
use App\Enums\JobTitles;
use App\Enums\UserRoles;
use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    function index()
    {
        $employees = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', UserRoles::ADMINISTRATOR->value);
        })->paginate(5)->withQueryString();
        return Inertia::render('HrDepartment/Employees', [
            'employees' => UserResource::collection($employees),
            'departments' => Departments::toArray(),
            'jobTitles' => JobTitles::toArray(),
        ]);
    }

    function store(EmployeeRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phoneNumber,
                'employee_code' => 'EMP-' . rand(0, 100000),
                'depratment' => $request->depratment,
                'job_title' => $request->jobTitle,
                'address' => $request->address,
                'salary' => $request->salary,
                'joined_at' => now(),
            ]);


            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    function edit(User $user)
    {
        return Inertia::render('HrDepartment/Employees', [
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