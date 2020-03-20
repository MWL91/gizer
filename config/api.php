<?php

return [
    'url' => [
        'results' => env('API_3TH_ENDPOINT_RESULTS', 'https://private-b5236a-jacek10.apiary-mock.com/results/games/')
    ],
    'response' => [
        'default' => env('API_RESPONSE_DEFAULT', 'json')
    ],
    'fetch' => [
        'always' => env('API_FETCH_ALWAYS', false)
    ]
];