<?php

return [
    'name' => 'Scenarios',
    'use_multi_store' => env('SCENARIO_USE_MULTI_STORE', false),
    'line_channel_id' => env('SCENARIO_LINE_CHANNEL_ID'),
    'access_token' => env('SCENARIO_LINE_ACCESS_TOKEN'),
    'channel_secret' => env('SCENARIO_LINE_CHANNEL_SECRET'),
    'loggable' => true,
    'user_model' => \App\Models\UserModel::class,
    'log_model' => \App\Models\LogModel::class,
    'guard_auth' => 'api'
];
