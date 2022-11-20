<?php

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\BaseSupport\BaseSupportController;
use App\Middleware\User\AuthenticationMiddleware;
use App\Services\AuctionOrderService;

/**
 * @ApiRouter(router="port/auction/order", method="get", intro="拍品订单", middleware={AuthenticationMiddleware::class})
 */
class AuctionOrder extends BaseSupportController
{


    /**
     * @ApiRouter(router="list", method="get", intro="拍品订单列表")
     * @Validator(attribute="status", required=false, rule="integer", intro="订单状态")
     * @Validator(attribute="page", required=false, rule="integer", intro="当前页码")
     * @Validator(attribute="number", required=false, rule="integer", intro="每页数量")
     */
    public function list(){
        $userId = $this->getAuthUserId();
        $status = (int) $this->request->input('status', 999);
        $page = (int) $this->request->input('page', 1);
        $number = (int) $this->request->input('number', 20);
        return $this->success('获取订单列表成功', [
            'list'  =>  AuctionOrderService::instance()->list($userId, $status, $page, $number)
        ]);
    }

    /**
     * @ApiRouter(router="add", method="get", intro="拍品订单详情")
     * @Validator(attribute="order_number", required=true, rule="string", intro="订单号")
     */
    public function detail(){
        $orderNumber = (string) $this->request->input('order_number');
        return $this->success('获取订单详情成功', AuctionOrderService::instance()->detail($orderNumber));
    }

    /**
     * @ApiRouter(router="pay", method="get", intro="支付拍品订单")
     * @Validator(attribute="order_number", required=true, rule="string", intro="订单号")
     */
    public function pay(){
        $userId = (int) $this->getAuthUserId();
        $openId = (string) $this->getAuthUserOpenId();
        $orderNumber = (string) $this->request->input('order_number');
        return $this->success('获取支付信息详情成功', AuctionOrderService::instance()->payConfig($userId, $openId, $orderNumber));
    }
}