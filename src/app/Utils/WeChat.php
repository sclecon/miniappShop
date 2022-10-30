<?php

namespace App\Utils;

use EasyWeChat\Factory;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Hyperf\Guzzle\CoroutineHandler;
use Hyperf\Utils\ApplicationContext;
use Psr\SimpleCache\CacheInterface;

class WeChat
{
    /**
     * @var null
     */
    private static $app;

    public static function app() {
        if (is_null(self::$app)){
            self::$app = Factory::officialAccount(self::config());
            $handler = new CoroutineHandler();
            $config = self::$app['config']->get('http', []);
            $config['handler'] = $stack = HandlerStack::create($handler);
            self::$app->rebind('http_client', new Client($config));
            self::$app['guzzle_handler'] = $handler;
            self::$app->oauth->setGuzzleOptions([
                'http_errors' => false,
                'handler' => $stack,
            ]);
            self::$app['cache'] = ApplicationContext::getContainer()->get(CacheInterface::class);
        }
        return self::$app;
    }

    protected static function config() : array {
        return [
            'app_id'        =>      'wxd4573d78c8dd5ee9',
            'secret'        =>      'd0dc1a655a739b8ad5880af868221cfa',
            'token'         =>      'test1234'
        ];
    }
}