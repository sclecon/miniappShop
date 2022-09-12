<?php
/**
 * project name Sumod
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/8/17 15:28
 */

return [
    'appid' =>  env('UC_APPID', 1),
    'api'   =>  env('UC_API', 'http://127.0.0.1/uc_server'),
    'key'   =>  env('UC_KEY', 'secret'),
    'charset'   =>  env('UC_CHARSET', 'utf-8'),
    'ip'    =>  env('UC_IP', '127.0.0.1'),
    'handler'   =>  [
        'synlogin'  =>  \app\Services\UcService::class, // 同步登录接口逻辑
        'synlogout' =>  '', // 同步退出接口逻辑
    ]
];