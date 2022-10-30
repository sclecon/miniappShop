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
        $response = $this->request->input('echostr', $response->getContent());
        return $response;
    }
}