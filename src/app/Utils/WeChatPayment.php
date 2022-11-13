<?php

namespace App\Utils;

use App\Services\ConfigService;
use EasyWeChat\Factory;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Hyperf\Guzzle\CoroutineHandler;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\ApplicationContext;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;

class WeChatPayment
{

    public static function app() {

        $config = self::config();
        var_dump($config);
        $app = Factory::payment($config);
        $handler = new CoroutineHandler();

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
        $app['cache'] = ApplicationContext::getContainer()->get(CacheInterface::class);

        $config = $app['config']->get('http', []);
        $config['handler'] = $stack = HandlerStack::create($handler);
        $app->rebind('http_client', new Client($config));

        $app['guzzle_handler'] = $handler;

        $app->oauth->setGuzzleOptions([
            'http_errors' => false,
            'handler' => $stack,
        ]);

        return $app;
    }

    protected static function config() : array {
        return ConfigService::instance()->getWechatPayConfig();
    }
}