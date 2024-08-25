<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\RolesModels;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleOwner = RolesModels::where('name', 'owner')->first();

        User::create(
            [
                'name' => 'owner',
                'email' => 'owner@mail.com',
                'role_id' => $roleOwner->id,
                'password' => Hash::make('password'),
            ]

        );
    }
}
