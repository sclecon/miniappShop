<?php

namespace App\Utils;

use EasyWeChat\Factory;

class WeChat
{
    /**
     * @var null
     */
    private static $app;

    public static function app() {
        if (is_null(self::$app)){
            self::$app = Factory::officialAccount(self::config());
        }
        return self::$app;
    }

    protected static function config() : array {
        return [
            'app_id' => 'wx3cf0f39249eb0exx',
            'secret' => 'f1c242f4f28f735d4687abb469072axx',
            'response_type' =>  'array',
        ];
    }
}