<?php

namespace Database\Seeders;

use App\Models\RoleModel;
use App\Models\UserModel;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = RoleModel::where('name_role', 'admin')->first();

        UserModel::create([
            'id' => Str::uuid(),
            'm_role_id' => $adminRole->id,
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin123'),
            'status' => true
        ]);
    }
}
