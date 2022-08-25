<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::truncate();
        $roles = ['admin', 'writer'];

        foreach ($roles as $role) {
            Role::create(
                ['name' => $role]
            );
        }

    }
}
