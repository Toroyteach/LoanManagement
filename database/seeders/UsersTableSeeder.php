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
                'name'           => 'Andrew Wafula',
                'email'          => 'andrew.w.wafula@gmail.com',//real email
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'      => 'Andrew',
                'lastname'       => 'Wafula',
                'number'         => '254704144041',//andrew
                'nationalid'     => '12345610',
                'address'        => '123-here',
                'idno'           => '222222',
                'remember_token' => null,
            ],
            [
                'id'             => 3,
                'name'           => 'Emmanuel Accountant',
                'email'          => 'chirchir7370@gmail.com',//real email
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'      => 'Emmanuel',
                'lastname'       => 'Chirchir',
                'number'         => '254705814794', //chirchir
                'nationalid'     => '12345678',
                'address'        => '123-here',
                'idno'           => '333333',
                'remember_token' => null,
            ],
            [
                'id'             => 4,
                'name'           => 'Yvonne Maina Committee',
                'email'          => 'mtangazajisacco@gmail.com',//real email
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'      => 'Yvonne',
                'lastname'       => 'Committee',
                'number'         => '254726616120', // 
                'nationalid'     => '12345679',
                'address'        => '123-here',
                'idno'           => '444444',
                'remember_token' => null,
            ],
            [
                'id'             => 5,
                'name'           => 'Mark Wanjala',
                'email'          => 'Markbidii@gmail.com',//real email
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'      => 'Mark',
                'lastname'       => 'Member',
                'number'         => '254768292315',
                'nationalid'     => '12314611',
                'address'        => '123-here',
                'idno'           => '555555',
                'remember_token' => null,
            ],
            [
                'id'             => 6,
                'name'           => 'Faiza Najira',
                'email'          => '+254 769 399319',//real email
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'      => 'Fiaza',
                'lastname'       => 'Member',
                'number'         => '254769399319',//
                'nationalid'     => '12314511',
                'address'        => '123-here',
                'idno'           => '666666',
                'remember_token' => null,
            ],

            [
                'id'             => 7,
                'name'           => 'Aisha Saggaf Nadhir',
                'email'          => 'Aishasaggaf17@gmail.com',//real email
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'      => 'Andrew',
                'lastname'       => 'Executive',
                'number'         => '254720977994',//
                'nationalid'     => '4184706',
                'address'        => '123-here',
                'idno'           => '777777',
                'remember_token' => null,
            ],
            [
                'id'             => 8,
                'name'           => 'Benson Ontieri Nyagaka',
                'email'          => 'nyagakaontieri@gmail.com',//real email
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'      => 'Emmanuel',
                'lastname'       => 'Accountant',
                'number'         => '254724047931', //
                'nationalid'     => '11294307',
                'address'        => '123-here',
                'idno'           => '888888',
                'remember_token' => null,
            ],
            [
                'id'             => 9,
                'name'           => 'Catherine Achienga',
                'email'          => 'catherine.achienga@gmail.com',//real email
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'      => 'Yvonne',
                'lastname'       => 'Committee',
                'number'         => '254722421011', // 
                'nationalid'     => '22006148',
                'address'        => '123-here',
                'idno'           => '999999',
                'remember_token' => null,
            ],
            [
                'id'             => 10,
                'name'           => 'Eustace Kingsley Njeru',
                'email'          => 'eustacekingsley@gmail.com',//real email
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'      => 'Mark',
                'lastname'       => 'Member',
                'number'         => '254723699315',//
                'nationalid'     => '6132982',
                'address'        => '123-here',
                'idno'           => '101010',
                'remember_token' => null,
            ],
            [
                'id'             =>11,
                'name'           => 'Jane Nduku Festus',
                'email'          => 'jane.nduku@yahoo.com',//real email
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'      => 'Fiaza',
                'lastname'       => 'Member',
                'number'         => '254721873450',//
                'nationalid'     => '22522809',
                'address'        => '123-here',
                'idno'           => '110110',
                'remember_token' => null,
            ],
            [
                'id'             => 12,
                'name'           => 'Joseph Muyala Napali',
                'email'          => 'napali.jm@gmail.com',//real email
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'      => 'Andrew',
                'lastname'       => 'Executive',
                'number'         => '254721465912',//
                'nationalid'     => '8344509',
                'address'        => '123-here',
                'idno'           => '121212',
                'remember_token' => null,
            ],
            [
                'id'             => 13,
                'name'           => 'Linet Namayi Otenyo',
                'email'          => 'linnamayi@yahoo.com',//real email
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'      => 'Emmanuel',
                'lastname'       => 'Accountant',
                'number'         => '254722435894', //
                'nationalid'     => '10017050',
                'address'        => '123-here',
                'idno'           => '131313',
                'remember_token' => null,
            ],
            [
                'id'             => 14,
                'name'           => 'Liverson Mwasere',
                'email'          => 'lmwasere23@gmail.com',//real email
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'      => 'Yvonne',
                'lastname'       => 'Committee',
                'number'         => '254722329820', // 
                'nationalid'     => '16042326',
                'address'        => '123-here',
                'idno'           => '141414',
                'remember_token' => null,
            ],
            [
                'id'             => 15,
                'name'           => 'Nicholus Matheri Kigondu',
                'email'          => 'kigondunicholas@gmail.com',//real email
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'      => 'Mark',
                'lastname'       => 'Member',
                'number'         => '254722425095',//
                'nationalid'     => '21981241',
                'address'        => '123-here',
                'idno'           => '151515',
                'remember_token' => null,
            ],
            [
                'id'             => 16,
                'name'           => 'Yvonne Wambui',
                'email'          => 'wambuimainagrace@gmail.com',//real email
                'password'       => '$2y$10$PadOOF6GiHJqI1IQhPZNjeXkKGPip9vJXdhB5ra6lrvZdcZFZDCjy',
                'firstname'      => 'Fiaza',
                'lastname'       => 'Member',
                'number'         => '254726616120',//
                'nationalid'     => '31562303',
                'address'        => '123-here',
                'idno'           => '161616',
                'remember_token' => null,
            ]
        ];
        
        User::insert($users);
    }
}
