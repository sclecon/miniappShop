<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/11/2 17:54
 */

namespace App\Services;

use App\Exception\Service\UserPayServiceException;
use App\Model\UserPayModel;
use App\Services\BaseSupport\BaseSupportService;
use App\Utils\Http;
use App\Utils\WeChatPayment;

class UserPayService extends BaseSupportService
{
    protected $model = UserPayModel::class;

    public function unify(int $userId, string $openId, string $orderNumber, float $amount, string $type, string $title) : array {
        $this->getModel()->add([
            'order_id'  =>  $orderNumber,
            'user_id'   =>  $userId,
            'amount'    =>  $amount,
            'type'      =>  $type,
        ]);

        $orderDetail = [
            'body'  =>  $title,
            'out_trade_no'  =>  $orderNumber,
            'total_fee' =>  $amount * 100,
            'notify_url'    =>  $this->getNotifyUrl(),
            'trade_type'    =>  'JSAPI',
            'openid'        =>  $openId
        ];
        var_dump($orderDetail);
        $response = WeChatPayment::app()->order->unify($orderDetail);
        var_dump($response);
        if ($response['return_code'] !== 'SUCCESS' or $response['result_code'] !== 'SUCCESS'){
            throw new UserPayServiceException($response['return_msg']);
        }
        $prepayId = $response['prepay_id'];
        $payConfig = WeChatPayment::app()->jssdk->bridgeConfig($prepayId);
        return $payConfig;
    }

    public function getNotifyUrl() : string {
        return Http::instance()->getDomain().'/weixin/payment/notify';
    }

}