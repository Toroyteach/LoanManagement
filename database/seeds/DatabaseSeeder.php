<?php

namespace Database\Seeds;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function __construct()
    {
        dd('seeded');
    }


    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            StatusesTableSeeder::class,
            //LoanApplicationSeeder::class,
        ]);
    }
}
