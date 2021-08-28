<?php

namespace Database\Seeders;

use App\Status;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'id'   => 1,
                'name' => 'Processing',
            ],
            [
                'id'   => 2,
                'name' => 'Accountant Processing',
            ],
            [
                'id'   => 3,
                'name' => 'Accountant Approved',
            ],
            [
                'id'   => 4,
                'name' => 'Accountant Rejected',
            ],
            [
                'id'   => 5,
                'name' => 'Credit Committee Processing',
            ],
            [
                'id'   => 6,
                'name' => 'Credit Committee Approved',
            ],
            [
                'id'   => 7,
                'name' => 'Credit Committee Rejected',
            ],
            [
                'id'   => 8,
                'name' => 'Approved',
            ],
            [
                'id'   => 9,
                'name' => 'Rejected',
            ],
            [
                'id'   => 10,
                'name' => 'Paid',
            ],
            [
                'id'   => 11,
                'name' => 'Defaulted',
            ],
        ];

        Status::insert($statuses);
    }
}
