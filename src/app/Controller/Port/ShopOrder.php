<?php

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\BaseSupport\BaseSupportController;
use App\Services\ShopOrderService;

/**
 * @ApiRouter(router="port/shop/order", method="get", intro="订单模块")
 */
class ShopOrder extends BaseSupportController
{
    /**
     * @ApiRouter(router="place_an_order", method="put", intro="创建订单")
     * @Validator(attribute="shop_id", required=true, rule="integer", intro="商品名称")
     * @Validator(attribute="address_id", required=true, rule="integer", intro="收货地址ID")
     * @Validator(attribute="order_number", required=true, rule="integer", intro="购买数量")
     */
    public function placeAnOrder(){
        $userId = $this->getAuthUserId();
        $shopId = (int) $this->request->input('shop_id');
        $addressId = (int) $this->request->input('address_id');
        $buyNumber = (int) $this->request->input('order_number');
        $orderId = ShopOrderService::instance()->placeAnOrder($userId, $shopId, $addressId, $buyNumber);
        return $this->success('创建订单成功', [
            'order_number'  =>  $orderId
        ]);
    }

    /**
     * @ApiRouter(router="place_an_order", method="delete", intro="关闭订单")
     * @Validator(attribute="order_number", required=true, rule="string", intro="订单号")
     */
    public function close(){
        $userId = $this->getAuthUserId();
        $orderNumber = $this->request->input('order_number');
        ShopOrderService::instance()->closeOrder($userId, $orderNumber);
        return $this->success('关闭订单成功');
    }
}