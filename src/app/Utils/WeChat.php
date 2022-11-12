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

            $app = Factory::officialAccount(ConfigService::instance()->getWechatConfig());
            $handler = new CoroutineHandler();

            $config = $app['config']->get('http', []);
            $config['handler'] = $stack = HandlerStack::create($handler);
            $app->rebind('http_client', new Client($config));

            $app['guzzle_handler'] = $handler;

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