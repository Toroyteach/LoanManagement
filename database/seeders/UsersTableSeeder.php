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
                'email'          => 'tonytoroitich@gmail.com',//real email
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'      => 'Anthony',
                'lastname'       => 'Toroyteach',
                'number'         => '254710516288', //tony
                'nationalid'     => '1555961',
                'address'        => '123-here',
                'idno'           => '111111',
                'remember_token' => null,
            ],
            [
                'id'             => 2,
                'name'           => 'Emmanuel Accountant',
                'email'          => 'chirchir7370@gmail.com',//real email
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'      => 'Emmanuel',
                'lastname'       => 'Accountant',
                'number'         => '254705814794', //chirchir
                'nationalid'     => '12345678',
                'address'        => '123-here',
                'idno'           => '222222',
                'remember_token' => null,
            ],
            [
                'id'             => 3,
                'name'           => 'Yvonne Maina Committee',
                'email'          => 'mtangazajisacco@gmail.com',//real email
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'      => 'Yvonne',
                'lastname'       => 'Committee',
                'number'         => '254726616120', // 
                'nationalid'     => '12345679',
                'address'        => '123-here',
                'idno'           => '333333',
                'remember_token' => null,
            ],
            [
                'id'             => 4,
                'name'           => 'Andrew Executive',
                'email'          => 'andrew.w.wafula@gmail.com',//real email
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'      => 'Andrew',
                'lastname'       => 'Executive',
                'number'         => '254704144041',//andrew
                'nationalid'     => '12345610',
                'address'        => '123-here',
                'idno'           => '444444',
                'remember_token' => null,
            ],
            [
                'id'             => 5,
                'name'           => 'Alex Kibet',
                'email'          => 'alexronoh16@gmail.com',//real email
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'      => 'Alex',
                'lastname'       => 'Member',
                'number'         => '254704567798',//kibet
                'nationalid'     => '12345611',
                'address'        => '123-here',
                'idno'           => '555555',
                'remember_token' => null,
            ],
            [
                'id'             => 6,
                'name'           => 'Sipedi Santa',
                'email'          => 'santaashley542@gmail.com',//real email
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'      => 'Santa',
                'lastname'       => 'Member',
                'number'         => '254796671566',//santa
                'nationalid'     => '12314611',
                'address'        => '123-here',
                'idno'           => '666666',
                'remember_token' => null,
            ],
            [
                'id'             => 7,
                'name'           => 'Mark Wanjala',
                'email'          => 'Markbidii@gmail.com',//real email
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'      => 'Mark',
                'lastname'       => 'Member',
                'number'         => '254768292315',//kibet
                'nationalid'     => '12314611',
                'address'        => '123-here',
                'idno'           => '777777',
                'remember_token' => null,
            ],
            [
                'id'             => 8,
                'name'           => 'Faiza Najira',
                'email'          => '+254 769 399319',//real email
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'      => 'Fiaza',
                'lastname'       => 'Member',
                'number'         => '254769399319',//kibet
                'nationalid'     => '12314611',
                'address'        => '123-here',
                'idno'           => '888888',
                'remember_token' => null,
            ],
            [
                'id'             => 9,
                'name'           => 'Markk Ndunga',
                'email'          => 'Markwasndunga@gmail.com',//real email
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'      => 'Markk',
                'lastname'       => 'Member',
                'number'         => '254716315141',//Mark
                'nationalid'     => '12314621',
                'address'        => '123-here',
                'idno'           => '999999',
                'remember_token' => null,
            ],
            [
                'id'             => 10,
                'name'           => 'Olimpas Kibet',
                'email'          => 'Givanliconti@gmail.com',//real email
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'      => 'Olympas',
                'lastname'       => 'Member',
                'number'         => '254727628930',//kibet
                'nationalid'     => '12314631',
                'address'        => '123-here',
                'idno'           => '101010',
                'remember_token' => null,
            ],
        ];
        
        User::insert($users);
    }
}
