<?php

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\BaseSupport\BaseSupportController;
use App\Services\ShopOrderService;
use App\Services\UserPayService;
use App\Middleware\User\AuthenticationMiddleware;

/**
 * @ApiRouter(router="port/shop/order", method="get", intro="订单模块", middleware={AuthenticationMiddleware::class})
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
     * @ApiRouter(router="close", method="delete", intro="关闭订单")
     * @Validator(attribute="order_number", required=true, rule="string", intro="订单号")
     */
    public function close(){
        $userId = $this->getAuthUserId();
        $orderNumber = $this->request->input('order_number');
        ShopOrderService::instance()->closeOrder($userId, $orderNumber);
        return $this->success('关闭订单成功');
    }

    /**
     * @ApiRouter(router="list", method="get", intro="获取订单列表")
     * @Validator(attribute="status", required=false, rule="integer", intro="订单状态 1=待支付 0=已取消 2=待配送 3=配送中 4=已完成 5=不限制")
     * @Validator(attribute="order", required=false, rule="string", intro="排序字段 默认created_time")
     * @Validator(attribute="desc", required=false, rule="string", intro="排序方式 desc 或 asc")
     * @Validator(attribute="page", required=false, rule="integer", intro="分页")
     * @Validator(attribute="number", required=false, rule="integer", intro="显示数量")
     */
    public function list(){
        $userId = $this->getAuthUserId();
        $status = (int) $this->request->input('status', 5);
        $order = $this->request->input('order', 'created_time');
        $desc = in_array($this->request->input('desc', 'desc'), ['desc', 'asc']) ? $this->request->input('desc', 'desc') : 'desc';
        $page = (int) $this->request->input('page', 1);
        $number = (int) $this->request->input('number', 20);
        return $this->success('获取订单列表成功', [
            'list'  =>  ShopOrderService::instance()->list($userId, $status, $order, $desc, $page, $number),
        ]);
    }

    /**
     * @ApiRouter(router="detail", method="get", intro="获取订单详情")
     * @Validator(attribute="order_number", required=false, rule="string", intro="订单号")
     */
    public function detail(){
        $userId = $this->getAuthUserId();
        $orderNumber = $this->request->input('order_number');
        $detail = ShopOrderService::instance()->detail($userId, $orderNumber);
        return $this->success('获取订单详情成功', $detail);
    }

    /**
     * @ApiRouter(router="pay", method="get", intro="获取支付配置")
     * @Validator(attribute="order_number", required=false, rule="string", intro="订单号")
     */
    public function pay(){
        $userId = $this->getAuthUserId();
        $openId = $this->getAuthUserOpenId();
        $orderNumber = $this->request->input('order_number');
        $detail = ShopOrderService::instance()->detail($userId, $orderNumber);
        $payParams = UserPayService::instance()->unify($userId, $openId, $orderNumber, $detail['total_price'], 'shopOrder');
        return $this->success('获取支付配置成功', [
            'payParams' =>  $payParams,
            'amount'    =>  $detail['total_price'],
            'name'      =>  $detail['shop_name'],
        ]);
    }
}