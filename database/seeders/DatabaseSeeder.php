<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // Tạo super admin
        Admin::create([
            'email' => 'superadmin@example.com',
            'user_name' => 'SuperAdmin',
            'password' => Hash::make('password'),
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'birthday' => '1998-10-04',
        ]);

        // Tạo admin
        Admin::create([
            'email' => 'admin@example.com',
            'user_name' => 'admin',
            'password' => Hash::make('password'),
            'first_name' => 'Admin',
            'last_name' => 'User',
            'birthday' => '1998-10-04',
        ]);

        // Tạo user
        User::create([
            'email' => 'user@example.com',
            'user_name' => 'user',
            'password' => Hash::make('password'),
            'first_name' => 'User',
            'last_name' => 'Test',
            'birthday' => '1998-10-04',
        ]);

        User::factory(49)->create();
        ProductCategory::factory(10)->create();
        Product::factory(100)->create();
    }
}
