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
        try {
            $result = WeChatPayment::app()->verify($this->request->getBody())->toArray();
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage());
        }
        if (array_key_exists("return_code", $result) && array_key_exists("result_code", $result) && $result["return_code"] == "SUCCESS" && $result["result_code"] == "SUCCESS") {
            UserPayService::instance()->notify($result['out_trade_no']);
        }
        return WeChatPayment::app()->success()->getContent();
    }
}