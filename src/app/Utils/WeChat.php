<?php

namespace App\Utils;

use App\Services\ConfigService;
use EasyWeChat\Factory;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Hyperf\Devtool\Adapter\AbstractAdapter;
use Hyperf\Guzzle\CoroutineHandler;
use Hyperf\Guzzle\HandlerStackFactory;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\ApplicationContext;
use Psr\SimpleCache\CacheInterface;
use Overtrue\Socialite\Providers\AbstractProvider;

class WeChat
{
    /**
     * @var null
     */
    private static $app;

    public static function app() {
        if (is_null(self::$app)){
//            self::$app = Factory::officialAccount(self::config());
//            $handler = new CoroutineHandler();
//            $config = self::$app['config']->get('http', []);
//            $config['handler'] = $stack = HandlerStack::create($handler);
//            self::$app->rebind('http_client', new Client($config));
//            self::$app['guzzle_handler'] = $handler;
//            self::$app->oauth->setGuzzleOptions([
//                'http_errors' => false,
//                'handler' => $stack,
//            ]);
//            self::$app['cache'] = ApplicationContext::getContainer()->get(CacheInterface::class);

            $app = Factory::officialAccount(self::config());
            $config = $app['config']->get('http', []);
            $config['handler'] = ApplicationContext::getContainer()->get(HandlerStackFactory::class)->create();
            $app->rebind('http_client', new Client($config));
            $app['guzzle_handler'] = new CoroutineHandler();
            AbstractProvider::setGuzzleOptions([
                'http_errors' => false,
                'handler' => HandlerStack::create(new CoroutineHandler())
            ]);
            $app['cache'] = ApplicationContext::getContainer()->get(CacheInterface::class);
            $request = ApplicationContext::getContainer()->get(RequestInterface::class);
            $get = $request->getQueryParams();
            $post = $request->getParsedBody();
            $cookie = $request->getCookieParams();
            $files = $request->getUploadedFiles();
            $server = $request->getServerParams();
            $xml = $request->getBody()->getContents();
            $app['request'] = new \GuzzleHttp\Psr7\Request($get, $post, [], $cookie, $files, $server, $xml);
            self::$app = $app;
        }
        return self::$app;
    }

    protected static function config() : array {
        return ConfigService::instance()->getWechatConfig();
    }
}