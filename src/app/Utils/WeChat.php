<?php

namespace App\Utils;

use App\Services\ConfigService;
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
            $config = self::config();
            var_dump($config);
            self::$app = Factory::officialAccount($config);
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
        return ConfigService::instance()->getWechatConfig();
    }
}