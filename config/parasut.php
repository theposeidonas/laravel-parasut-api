<?php

/*
|--------------------------------------------------------------------------
| Paraşüt API Config Parameters
|--------------------------------------------------------------------------
|
| This is Paraşüt API configuration parameters; set them according to your preferences. Don't touch to use by .env file.
|
*/

return [
    'username' => env('PARASUT_USERNAME'),
    'password' => env('PARASUT_PASSWORD'),
    'company_id' => env('PARASUT_COMPANY_ID'),
    'client_id' => env('PARASUT_CLIENT_ID'),
    'client_secret' => env('PARASUT_CLIENT_SECRET'),
    'redirect_uri' => env('PARASUT_REDIRECT_URI'),
    'api_url' => env('PARASUT_API_URL', 'https://api.parasut.com/v4/'),
];
