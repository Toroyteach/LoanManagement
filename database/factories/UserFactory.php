<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\LoanApplication;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

// $factory->define(User::class, function (Faker $faker) {
//     return [
//         'name' => $faker->name,
//         'email' => $faker->unique()->safeEmail,
//         'email_verified_at' => now(),
//         'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
//         'remember_token' => Str::random(10),
//     ];
// });

$factory->define(App\LoanApplication::class, function (Faker\Generator $faker) {

    return [
        'loan_amount' => $faker->numberBetween($min = 500, $max = 90000),
        'loan_type' => $faker->randomElement($array = array ('Emergency','SchoolFees','Development', 'TopUp')),
        'repaid_amount' => $faker->numberBetween($min = 1000, $max = 9000),
        'repaid_status' => $faker->randomElement($array = array (1, 0)),
        'desciption' => $faker->realText($maxNbChars = 200, $indexSize = 2),
        'duration' => $faker->numberBetween($min = 1000, $max = 9000),
        'repayment_date' => $faker->dateTimeBetween($startDate = 'now', $endDate = '+2 years', $timezone = 'Africa/Nairobi'),
        'status_id' => $faker->numberBetween($min = 1, $max = 9),
        'analyst_id' => $faker->$faker->randomElement($array = array (49, 51, 52, 2, 32)),
        'cfo_id' => 3,
        'created_by_id' => $faker->$faker->randomElement($array = array (4, 27)),

    ];

});
