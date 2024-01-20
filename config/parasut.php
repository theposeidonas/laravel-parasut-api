<?php

/*
|--------------------------------------------------------------------------
| Paraşüt API Config Parameters
|--------------------------------------------------------------------------
|
| This is Paraşüt API configuration parameters; set them according to your preferences. Don't touch to use by .env file.
|
*/

return  [
    'username' => env('PARASUT_USERNAME'),
    'password' => env('PARASUT_PASSWORD'),
    'is_stage' => env('PARASUT_IS_STAGE', 0),
    'company_id' => env('PARASUT_COMPANY_ID'),
    'client_id' => env('PARASUT_CLIENT_ID'),
    'client_secret' => env('PARASUT_CLIENT_SECRET'),
    'redirect_uri' => env('PARASUT_REDIRECT_URI')
];