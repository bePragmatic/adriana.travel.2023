<?php

return [

    'shop_id' => env('WSPAY_SHOP_ID'),

    'secret_key' => env('WSPAY_SECRET_KEY'),

    'wspay_uri' => env('WSPAY_URI', 'https://formtest.wspay.biz/Authorization.aspx'),

    'production' => env('WSPAY_TEST_MODE', false),

];
