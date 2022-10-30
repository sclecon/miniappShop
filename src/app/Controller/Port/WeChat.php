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
            'app_id'        =>      'wx7e45af66afb6ecac',
            'secret'        =>      '51753f541540e817d192277c757b8d0f',
            'token'         =>      'test1234',
            'response_type' => 'array',
        ];

        $app = Factory::officialAccount($config);

        $response = $app->server->serve();

        // 将响应输出
        return $response; // Laravel 里请使用：return $response;
    }
}