<?php

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Controller\BaseSupport\BaseSupportController;
use EasyWeChat\Factory;

/**
 * @ApiRouter(router="wechat", method="get", intro="微信接口")
 */
class WeChat extends BaseSupportController
{
    /**
     * @ApiRouter(router="server", method={"get", "post", "put"}, intro="服务接口")
     */
    public function server(){
        $response = \App\Utils\WeChat::app()->server->serve();
        return $response->send();
    }

    /**
     * @ApiRouter(router="server/test", method={"get", "post", "put"}, intro="服务接口")
     */
    public function test(){
        $config = [
            'app_id'        =>      'wxd4573d78c8dd5ee9',
            'secret'        =>      'd0dc1a655a739b8ad5880af868221cfa',
            'token'         =>      'test1234',
            'response_type' =>      'array',
            // 'aes_key'       =>      '2OerKZJ3TBmMftUWEGR0hYVdITqzTAMnLj39dYd397M'
        ];

        $app = Factory::officialAccount($config);

        $response = $app->server->serve();

        var_dump('微信来了');

        var_dump($_SERVER);

        var_dump($this->request->getHeaders());

        // 将响应输出
        $response = $response->getContent(); // Laravel 里请使用：return $response;

        var_dump($response);

        var_dump($this->request->inputs(['signature', 'timestamp', 'nonce', 'echostr']));

        $response = $this->request->input('echostr', 'success');

        var_dump($response);

        return $response;
    }
}