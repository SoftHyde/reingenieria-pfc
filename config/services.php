<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => '1888349911437822',
        'client_secret' => 'cf1d16d213eebe47c0e7155a6461770d',
        'redirect' => 'http://pfc.local/callback/facebook',
    ],

    'twitter' => [
        'client_id' => 'Jkzo88h1e5Mkkn1QIaFpcGsGk',
        'client_secret' => 'nxMTkcLtH1Ns09gSElOrCZCVUCH8t2U6CDVP5qNq04snIbriti',
        'redirect' => 'http://pfc.local/callback/twitter',
    ],

    'google' => [
        'client_id' => '271017504733-en1h89ojq6fvbhsrige9fsbjqs1r1q35.apps.googleusercontent.com',
        'client_secret' => 'qChjz9QzGiyoAil2TzlDHwpQ',
        'redirect' => 'http://pfc.local/callback/google',
    ],
];
