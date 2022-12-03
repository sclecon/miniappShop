<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/11/3 17:26
 */

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Controller\BaseSupport\BaseSupportController;
use App\Middleware\User\AuthenticationMiddleware;
use App\Services\UserPayService;
use App\Utils\WeChatPayment;

/**
 * @ApiRouter(router="port/wechat/pay", method="get", intro="支付相关")
 */
class Pay extends BaseSupportController
{
    /**
     * @ApiRouter(router="notify", method={"get", "post", "put"}, intro="支付异步通知")
     */
    public function notify(){
        var_dump('进入了微信回调');
        $result = WeChatPayment::app()->verify()->toArray();
        var_dump($result);
        if (array_key_exists("return_code", $result) && array_key_exists("result_code", $result) && $result["return_code"] == "SUCCESS" && $result["result_code"] == "SUCCESS") {
            var_dump('支付成功的业务逻辑处理');
            $orderId = $result['out_trade_no'];
            var_dump($orderId);
            UserPayService::instance()->notify($orderId);
        }
        return WeChatPayment::app()->success()->getContent();
    }
}