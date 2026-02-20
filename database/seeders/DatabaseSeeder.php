<?php

namespace Database\Seeders;

use App\Models\PhoneBrand;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Phone;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $phoneBrands = [
            'Iphone',
            'Nokia',
            'Xiaomi',
            'Sony'
        ];
        foreach ($phoneBrands as $brand) {
            PhoneBrand::query()->firstOrCreate([
                'name' => $brand
            ], [
                'name' => $brand
            ]);
        }
        $roles = [
            'Guest',
            'Moderator',
            'Admin',
        ];
        foreach ($roles as $role) {
            Roles::query()->firstOrCreate([
                'role' => $role
            ], [
                'role' => $role
            ]);
        }
        User::factory()->has(Phone::factory()->count(1), 'phones')->count(5)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
