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
                'title' => 'Member',
            ],
            [
                'id'    => 3,
                'title' => 'Accountant',
            ],
            [
                'id'    => 4,
                'title' => 'Credit Committee',
            ],
            [
                'id'    => 5,
                'title' => 'Executive',
            ],
        ];

        Role::insert($roles);
    }
}
