<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Anthony Toroyteach',
                'email'          => 'admin@admin.com',
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'          => 'Anthony',
                'lastname'          => 'Toroyteach',
                'number'          => '254710516288',
                'nationalid'          => 'admin@admin.com',
                'remember_token' => null,
            ],
            [
                'id'             => 2,
                'name'           => 'John Accountant',
                'email'          => 'johnAcct@admin.com',
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'          => 'John',
                'lastname'          => 'Accountant',
                'number'          => '254711111111',
                'nationalid'          => '12345678',
                'remember_token' => null,
            ],
            [
                'id'             => 3,
                'name'           => 'Harry Committee',
                'email'          => 'harryCom@admin.com',
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'          => 'Harry',
                'lastname'          => 'Committee',
                'number'          => '254722222222',
                'nationalid'          => '12345679',
                'remember_token' => null,
            ],
            [
                'id'             => 4,
                'name'           => 'Andrew Executive',
                'email'          => 'andrew@admin.com',
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'          => 'Andrew',
                'lastname'          => 'Executive',
                'number'          => '254704144041',
                'nationalid'          => '12345610',
                'remember_token' => null,
            ],
            [
                'id'             => 5,
                'name'           => 'Alex Kibet',
                'email'          => 'alex@gmail.com.com',
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'          => 'Alex',
                'lastname'          => 'Kibet',
                'number'          => '254704567798',
                'nationalid'          => '12345611',
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}
