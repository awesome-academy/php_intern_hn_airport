<?php

return [
    'anonymous_user' => 'images/anonymous-user.png',
    'google_map' => 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=',
    'datetime' => 'Y-m-d H:i:s',
    'hour' => 'H',
    'title' => [
        'title_agency_register' => 'Agency Register',
        'title_agency_login' => 'Agency Login',
        'title_host_register' => 'Host Register',
        'title_host_login' => 'Host Login',
        'title_admin_login' => 'Admin Login',
        '404' => 'Page Not Found',
        'title_admin' => 'Admin Local Driver',
        'title_agency' => 'Agency Local Driver',
        'title_host' => 'Host Local Driver',
    ],
    'const' => [
        'zero' => 0,
        'one' => 1,
        'user_active' => 1,
        'user_inactive' => 0,
        'request_new' => 0,
        'request_cancel' => 2,
        'request_to_contract' => 1,
        'request_pickup' => 0,
        'request_dropoff' => 1,
        'request_to_contract' => 1,
        'request_canceled' => 2,
        'contract_new' => 0,
        'contract_cancel' => 1,
        'fee_basic' => 8,
        'bonus_basic' => 6,
        'm_to_km' => 1000,
        'percent' => 100,
        'format_money' => -3,
        'month_in_year' => 12,
        'num_noti' => 3,
        'num_email' => 8,
    ],
    'role' => [
        'agency' => 'agency',
        'admin' => 'admin',
        'host' => 'host',
        'customer' => 'customer',
    ],
    'status' => [
        'new' => 'new',
        'cancel' => 'cancel',
    ],
    'image' => [
        'contract' => 'public/images/contracts',
    ],
    'distance' => [
        'tier_1' => 10,
        'tier_2' => 20,
        'tier_special' => 30,
    ],
    'car' => [
        'type_1' => 4,
        'type_2' => 5,
        'type_3' => 7,
        'type_4' => 16,
    ],
    'province_airport' => [
        'HN' => 1,
    ],
    'time' => [
        'condition_1' => 23,
        'condition_2' => 9,
    ],
    'lang' => [
        'en' => 'en',
        'vi' => 'vi',
    ],
    'chart' => [
        'monthly' => 'monthly',
        'yearly' => 'yearly',
    ],
    'excel' => [
        'path' => 'excels/',
        'default' => 'DailyReport.xlsx',
    ], 
    'config_type' => [
        'cost' => 'cost',
        'distance' => 'distance',
    ],
];
