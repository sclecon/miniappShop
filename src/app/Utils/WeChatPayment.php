<?php

namespace App\Utils;

use App\Services\ConfigService;
use Yansongda\Pay\Pay;

class WeChatPayment
{

    public static function app(){
        $config = self::config();
        return Pay::wechat($config);
    }

    protected static function config() : array {
        return ConfigService::instance()->getWechatPayConfig();
    }
}