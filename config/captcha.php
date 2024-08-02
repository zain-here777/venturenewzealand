<?php

return [
    'secret' => env('RECAPTCHA_V3_SECRET_KEY'),
    'sitekey' => env('RECAPTCHA_V3_SITE_KEY'),
    'options' => [
        'timeout' => 30,
    ],
];
