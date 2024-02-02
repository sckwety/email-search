<?php

return [
    [
        'searchPath' => 'mock/provider1/email',
        'email' => env('PROVIDER_EMAIL'),
        'password' => env('PROVIDER_PASSWORD'),
        'searchParametersRequired' => ['name', 'company']
    ],
    [
        'searchPath' => 'mock/provider2/email',
        'email' => env('PROVIDER_EMAIL'),
        'password' => env('PROVIDER_PASSWORD'),
        'searchParametersRequired' => ['linkedInProfileUrl']
    ],
    [
        'searchPath' => 'mock/provider3/email',
        'email' => env('PROVIDER_EMAIL'),
        'password' => env('PROVIDER_PASSWORD'),
        'searchParametersRequired' => ['linkedInProfileUrl', 'company']
    ]
];
