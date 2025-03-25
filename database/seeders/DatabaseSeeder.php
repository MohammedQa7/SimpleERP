<?php

namespace Database\Seeders;

use App\Enums\UserRoles;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Category::factory(40)->create();
        // Product::factory(40)->create();
        // Customer::factory(40)->create();
        // User::factory(10)->create();

        // $roles = UserRoles::toArray();

        // foreach ($roles as $role) {
        //     Role::create(['name' => $role['value']]);
        // }

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}