<?php
return [
    'Emergency' => [
            'max_amount' => '50000',
            'max_duration' => '12',
            'interest' =>  '1',
            'reducing_balance' => true,
    ],
    'InstantLoan' => [
            'max_amount' => '20000',
            'max_duration' => '6',
            'interest' => '10',
            'reducing_balance' => false,
    ],
    'SchoolFees' => [
            'max_amount' => '',
            'max_duration' => '36',
            'interest' => '1',
            'reducing_balance' => true,
    ],
    'Development' => [
            'max_amount' => '',
            'max_duration' => '36',
            'interest' => '1',
            'reducing_balance' => true,
    ],

];