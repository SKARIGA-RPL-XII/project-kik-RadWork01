<?php

namespace Database\Seeders;

use App\Models\RoleModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoleModel::create([
            'id' => Str::uuid(),
            'name_role' => 'admin',
            'permissions' => ['*']
        ]);

        RoleModel::create([
            'id' => Str::uuid(),
            'name_role' => 'guru',
            'permissions' => []
        ]);

        RoleModel::create([
            'id' => Str::uuid(),
            'name_role' => 'siswa',
            'permissions' => []
        ]);
    }
}
