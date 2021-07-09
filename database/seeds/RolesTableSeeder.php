<?php

namespace Database\Seeders;

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'id'    => 1,
                'title' => 'Admin',
            ],
            [
                'id'    => 2,
                'title' => 'User',
            ],
            [
                'id'    => 3,
                'title' => 'Analyst',
            ],
            [
                'id'    => 4,
                'title' => 'CFO',
            ],
            [
                'id'    => 5,
                'title' => 'Manager',
            ],
        ];

        Role::insert($roles);
    }
}
