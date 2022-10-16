<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    public function run()
    {
        User::find(1)->roles()->attach(1);
        $users = User::where('id', '<>', 1)->get();

        foreach ($users as $user) {
            $user->roles()->attach(2);
        }
    }
}
