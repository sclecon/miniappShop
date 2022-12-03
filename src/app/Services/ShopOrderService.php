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
use App\Utils\Http;

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
            'shop_image'=>  isset($shop['shop_image'][0]) ? $shop['shop_image'][0] : '',
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

    public function list(int $userId, int $status, string $order, string $desc, int $page, int $number){
        $list = $this->getModel();
        $list = $list->where('user_id', $userId);
        if ($status !== 5){
            $list = $list->where('status', $status);
        }
        $list = $list->orderBy($order, $desc);
        $list = $list->forPage($page, $number);
        $list = $list->select(['shop_name', 'shop_image', 'order_number', 'shop_price', 'buy_number', 'total_price', 'status', 'payed', 'sended']);
        $list = $list->get()->toArray();
        foreach ($list as $key => $value){
            $list[$key]['shop_image'] = Http::instance()->image($value['shop_image']);
        }
        return $list;
    }

    public function detail(int $userId, string $orderNumber) : array {
        $order = $this->getModel()->where('user_id', $userId)->where('order_number', $orderNumber)->first();
        if (!$order){
            throw new ShopOrderServiceException('订单不存在');
        }
        $order->shop_image = Http::instance()->image($order->shop_image);
        return $order->toArray();
    }

    protected function createOrderNumber() : string {
        return 'shop'.date('YmdHis', time()).rand(1000, 9999);
    }

    public function notify(string $orderNumber){
        $order = $this->getModel()->where('order_number', $orderNumber)->first();
        if (!$order){
            throw new ShopOrderServiceException('商品订单不存在');
        }
        if ($order->payed == 0){
            throw new ShopOrderServiceException('商品订单已关闭');
        }
        if ($order->payed == 2){
            throw new ShopOrderServiceException('商品订单已支付成功');
        }
        return $this->getModel()->where('order_number', $orderNumber)->update([
            'payed'     =>  2,
            'status'    =>  2,
            'payed_time'    =>  time(),
        ]);
    }
}