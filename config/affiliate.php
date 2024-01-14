<?php

return [
    'cookie_name' => env('AFFILIATE_COOKIE_NAME', 'aff'),
    'cookie_expiry_minutes' => env('AFFILIATE_COOKIE_EXPIRY_MINUTES', 60 * 24 * 30),
    'query_string_parameter' => env('AFFILIATE_QUERY_STRING_PARAMETER', 'aff'),
];
