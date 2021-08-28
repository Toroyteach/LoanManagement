<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Verification Authentication Enabled
    |--------------------------------------------------------------------------
    */

    'laravel2stepEnabled' => env('LARAVEL_2STEP_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Verification Database Settings
    |--------------------------------------------------------------------------
    */

    'laravel2stepDatabaseConnection'  => env('LARAVEL_2STEP_DATABASE_CONNECTION', 'mysql'),
    //'laravel2stepDatabaseTable'       => env('LARAVEL_2STEP_DATABASE_TABLE', 'twoStepAuth'),
    'laravel2stepDatabaseTable'       => env('LARAVEL_2STEP_DATABASE_TABLE', 'two_step_auth_tables'),

    /*
    |--------------------------------------------------------------------------
    | Laravel Default User Model
    |--------------------------------------------------------------------------
    */

    'defaultUserModel' => env('LARAVEL_2STEP_USER_MODEL', 'App\User'),

    /*
    |--------------------------------------------------------------------------
    | Verification Email Settings
    |--------------------------------------------------------------------------
    */

    'verificationEmailFrom'     => env('LARAVEL_2STEP_EMAIL_FROM', env('MAIL_USERNAME')),
    'verificationEmailFromName' => env('LARAVEL_2STEP_EMAIL_FROM_NAME', config('app.name').' 2-Step Verification'),

    /*
    |--------------------------------------------------------------------------
    | Verification Timings Settings
    |--------------------------------------------------------------------------
    */

    'laravel2stepExceededCount'             => env('LARAVEL_2STEP_EXCEEDED_COUNT', 3), //number of times you can input wrong verification code
    'laravel2stepExceededCountdownMinutes'  => env('LARAVEL_2STEP_EXCEEDED_COUNTDOWN_MINUTES', 1440), //DAYS OR HOURS before your allowed to try again after failed more than 3 times
    'laravel2stepVerifiedLifetimeMinutes'   => env('LARAVEL_2STEP_VERIFIED_LIFETIME_MINUTES', 120), // time left before you are required to login again with code. ie refresh pages to login after
    'laravel2stepTimeResetBufferSeconds'    => env('LARAVEL_2STEP_RESET_BUFFER_IN_SECONDS', 300), //time left before the verification code is sent again if it wasnt input. needs browser refresh

    /*
    |--------------------------------------------------------------------------
    | Verification blade view style settings
    |--------------------------------------------------------------------------
    */

    'laravel2stepAppCssEnabled'         => env('LARAVEL_2STEP_APP_CSS_ENABLED', false),
    'laravel2stepAppCss'                => env('LARAVEL_2STEP_APP_CSS', 'css/app.css'),
    'laravel2stepBootstrapCssCdnEnbled' => env('LARAVEL_2STEP_BOOTSTRAP_CSS_CDN_ENABLED', true),
    'laravel2stepBootstrapCssCdn'       => env('LARAVEL_2STEP_BOOTSTRAP_CSS_CDN', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'),
    'laravel2stepCssFile'               => env('LARAVEL_2STEP_CSS_FILE', 'css/laravel2step/app.css'),

];
