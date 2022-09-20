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
            'app_id' => 'wxd4573d78c8dd5ee9',
            'secret' => 'd0dc1a655a739b8ad5880af868221cfa',
            'response_type' =>  'array',
        ];
    }
}