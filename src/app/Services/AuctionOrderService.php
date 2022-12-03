<?php

namespace App\Services;

use App\Exception\Service\AuctionOrderServiceException;
use App\Model\AuctionOrderModel;
use App\Services\BaseSupport\BaseSupportService;
use App\Utils\ArrayExpand;

class AuctionOrderService extends BaseSupportService
{
    protected $model = AuctionOrderModel::class;

    public function createOrder(int $userId, int $auctionId, $joinPrice) : int {
        return $this->getModel()->add([
            'user_id'       =>  $userId,
            'auction_id'    =>  $auctionId,
            'amount'        =>  $joinPrice,
            'order_number'  =>  $this->createOrderNumber()
        ]);
    }

    protected function createOrderNumber() : string {
        return 'auction'.date('YmdHis', time()).rand(1000, 9999);
    }

    public function list(int $userId, int $status, int $page, int $number) : array {
        $model = $this->getModel()->where('user_id', $userId);
        if ($status !== 999){
            $model = $model->where('status', $status);
        }
        $list = $model->forPage($page, $number)->get();
        $list = $list ? $list->toArray() : [];
        $auctionIds = ArrayExpand::getKeys($list, 'auction_id');
        $allAuction = AuctionService::instance()->getAuctionListInAuctionIds($auctionIds);
        foreach ($list as $key => $item){
            $list[$key]['auction'] = isset($allAuction[$item['auction_id']]) ? $allAuction[$item['auction_id']] : [];
        }
        return $list;
    }

    public function detail(string $orderNumber) : array {
        $auctionOrder = $this->getModel()->where('order_number', $orderNumber)->first();
        $auctionOrder = $auctionOrder ? $auctionOrder->toArray() : [];
        if (!$auctionOrder){
            throw new AuctionOrderServiceException('订单不存在');
        }
        $auctionIds = [$auctionOrder['auction_id']];
        $allAuction = AuctionService::instance()->getAuctionListInAuctionIds($auctionIds);
        $auctionOrder['auction'] = isset($allAuction[$auctionOrder['auction_id']]) ? $allAuction[$auctionOrder['auction_id']] : [];
        return $auctionOrder;
    }

    public function payConfig(int $userId, string $openId, string $orderNumber) : array {
        $orderDetail = $this->detail($orderNumber);
        if (!$orderDetail){
            throw new AuctionOrderServiceException('订单不存在');
        }
        if ($orderDetail['status'] == 2){
            throw new AuctionOrderServiceException('订单已支付成功');
        }
        if ($orderDetail['status'] == 0){
            throw new AuctionOrderServiceException('订单已关闭');
        }
        return UserPayService::instance()->unify($userId, $openId, $orderNumber, $orderDetail['amount'], 'auction', '竞拍成功 - '.$orderDetail['auction']['name']);
    }

    public function notify(string $orderNumber){
        $order = $this->getModel()->where('order_number', $orderNumber)->first();
        if (!$order){
            throw new AuctionOrderServiceException('商品订单不存在');
        }
        if ($order->status == 3){
            throw new AuctionOrderServiceException('商品订单已关闭');
        }
        if ($order->payed == 2){
            throw new AuctionOrderServiceException('商品订单已支付成功');
        }
        return $this->getModel()->where('order_number', $orderNumber)->update([
            'status'    =>  2,
        ]);
    }
}