<?php

namespace App\Utils;

use App\Services\ConfigService;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\ApplicationContext;
use EasyWeChat\Factory;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Hyperf\Guzzle\CoroutineHandler;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;

class WeChat
{
    /**
     * @var null
     */
    private static $app;

    public static function app() {
        if (is_null(self::$app)){
            $container = ApplicationContext::getContainer();

            $app = Factory::officialAccount(ConfigService::instance()->getWechatConfig());
            $handler = new CoroutineHandler();

// 设置 HttpClient，部分接口直接使用了 http_client。
            $config = $app['config']->get('http', []);
            $config['handler'] = $stack = HandlerStack::create($handler);
            $app->rebind('http_client', new Client($config));

// 部分接口在请求数据时，会根据 guzzle_handler 重置 Handler
            $app['guzzle_handler'] = $handler;

// 如果使用的是 OfficialAccount，则还需要设置以下参数
            $app->oauth->setGuzzleOptions([
                'http_errors' => false,
                'handler' => $stack,
            ]);

            $hyperfRequest = ApplicationContext::getContainer()->get(RequestInterface::class);

            $get = $hyperfRequest->getQueryParams();
            $post = $hyperfRequest->getParsedBody();
            $cookie = $hyperfRequest->getCookieParams();
            $uploadFiles = $hyperfRequest->getUploadedFiles() ?? [];
            $server = $hyperfRequest->getServerParams();
            $xml = $hyperfRequest->getBody()->getContents();
            $files = [];
            /** @var \Hyperf\HttpMessage\Upload\UploadedFile $v */
            foreach ($uploadFiles as $k => $v) {
                $files[$k] = $v->toArray();
            }
            $request = new Request($get, $post, [], $cookie, $files, $server, $xml);
            $request->headers = new HeaderBag($hyperfRequest->getHeaders());
            $app->rebind('request', $request);

            self::$app = $app;
        }
        return self::$app;
    }

    protected static function config() : array {
        return ConfigService::instance()->getWechatConfig();
    }
}