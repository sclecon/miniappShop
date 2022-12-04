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
use function _PHPStan_76800bfb5\RingCentral\Psr7\uri_for;

class UserPayService extends BaseSupportService
{
    protected $model = UserPayModel::class;

    public function unify(int $userId, string $openId, string $orderNumber, float $amount, string $type, string $title) : array {

        $config = $this->getUnifyPayConfigByOrderNumber($orderNumber);
        if (!$config){
            $orderDetail = [
                'out_trade_no'  =>  $orderNumber,
                'body'  =>  $title,
                'total_fee' =>  $amount * 100,
                'openid'        =>  $openId
            ];
            $config = WeChatPayment::app()->mp($orderDetail)->toArray();

            $this->getModel()->add([
                'order_id'  =>  $orderNumber,
                'user_id'   =>  $userId,
                'amount'    =>  $amount,
                'type'      =>  $type,
                'pay_config'    =>  json_encode($config),
            ]);
        }

        return $config;
    }

    public function getNotifyUrl() : string {
        return Http::instance()->getDomain().'/port/wechat/pay/notify';
    }

    public function getUnifyPayConfigByOrderNumber(string $orderNumber) : array {
        $config = $this->getModel()->where('order_id', $orderNumber)->value('pay_config');
        return $config ? json_decode($config, true) : [];
    }

    public function notify(string $orderNumber){
        $order = $this->getModel()->where('order_id', $orderNumber)->first();
        if (!$order){
            throw new UserPayServiceException('订单不存在');
        }
        if ($order->status == 2){
            return true;
        }
        $this->getModel()->where('order_id', $orderNumber)->update(['status'=>2]);
        if ($order->type === 'shopOrder'){
            return ShopOrderService::instance()->notify($orderNumber);
        } else if ($order->type === 'auction'){
            return AuctionOrderService::instance()->notify($orderNumber);
        } else if ($order->type === 'deposit'){
            return UserDepositService::instance()->notify($orderNumber);
        }
    }

}