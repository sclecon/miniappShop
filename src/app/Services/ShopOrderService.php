<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/10/24 17:55
 */

namespace App\Services;

use App\Exception\Service\ShopOrderServiceException;
use App\Model\ShopOrderModel;
use App\Services\BaseSupport\BaseSupportService;

class ShopOrderService extends BaseSupportService
{
    protected $model = ShopOrderModel::class;

    public function placeAnOrder(int $userId, int $shopId, int $addressId, int $buyNumber) : string {
        $userInfo = UserService::instance()->getUserInfoByUserId($userId);
        if (!$userInfo){
            throw new ShopOrderServiceException('用户不存在，下单失败');
        }
        $shop = ShopService::instance()->detail($shopId);
        UserAddressService::instance()->detail($userId, $addressId);
        $orderCode = $this->createOrderNumber();
        $this->getModel()->add([
            'user_id'   =>  $userId,
            'shop_id'   =>  $shopId,
            'address_id'=>  $addressId,
            'username'  =>  $userInfo['username'],
            'shop_name' =>  $shop['name'],
            'order_number'  =>  $orderCode,
            'shop_price'    =>  $shop['price'],
            'buy_number'    =>  $buyNumber,
            'total_price'   =>  $buyNumber * $shop['price'],
            'submited_time' =>  time(),
        ]);
        return $orderCode;
    }

    public function closeOrder(int $userId, string $orderNumber){
        return $this->getModel()->where('user_id', $userId)->where('order_number', $orderNumber)->update(['status'=>0]);
    }

    protected function createOrderNumber() : string {
        return 'shop'.date('YmdHis', time()).rand(1000, 9999);
    }
}