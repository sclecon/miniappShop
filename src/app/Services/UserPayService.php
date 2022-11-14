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
            'out_trade_no'  =>  $orderNumber,
            'body'  =>  $title,
            'total_fee' =>  $amount * 100,
            'openid'        =>  $openId
        ];
        $result = WeChatPayment::app()->mp($orderDetail);
        var_dump($result->toArray());
        return $result->toArray();


    }

    public function getNotifyUrl() : string {
        return Http::instance()->getDomain().'/weixin/payment/notify';
    }

}