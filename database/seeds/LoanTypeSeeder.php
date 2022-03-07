<?php

use Illuminate\Database\Seeder;

class LoanTypeSeeder extends Seeder
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
                'name' => 'Emergency',
            ],
            [
                'id'   => 2,
                'name' => 'Instant Loan',
            ],
            [
                'id'   => 3,
                'name' => 'School Fees',
            ],
            [
                'id'   => 3,
                'name' => 'Development',
            ],
        ];

    }
}
