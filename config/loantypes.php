<?php
return [
    'emergency' => [
            'max_amount' => '50000',
            'max_duration' => '12',
            'interest' =>  '1',
            'reducing_balance' => true,
    ],
    'instantloan' => [
            'max_amount' => '20000',
            'max_duration' => '6',
            'interest' => '10',
            'reducing_balance' => false,
    ],
    'schoolfees' => [
            'max_amount' => '',
            'max_duration' => '36',
            'interest' => '1',
            'reducing_balance' => true,
    ],
    'development' => [
            'max_amount' => '',
            'max_duration' => '36',
            'interest' => '1',
            'reducing_balance' => true,
    ],

];