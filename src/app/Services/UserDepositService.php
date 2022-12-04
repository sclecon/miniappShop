<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/11/1 17:45
 */

namespace App\Services;

use App\Exception\Service\UserDepositServiceException;
use App\Model\UserDepositModel;
use App\Services\BaseSupport\BaseSupportService;
use App\Utils\ArrayExpand;

class UserDepositService extends BaseSupportService
{
    protected $model = UserDepositModel::class;

    public function list(int $userId, int $type, int $page, int $number) : array {
        $model = $this->getModel()->where('user_id', $userId);
        if ($type){
            $model = $model->where('type', $type);
        }
        $model = $model->forPage($page, $number);
        $list = $model->get()->toArray();
        foreach ($list as $key => $value){
            $list[$key]['ymd'] = date('Y-m-d', $value['created_time']);
        }
        return ArrayExpand::columns($list, 'ymd', 'deposit_id');
    }

    public function hasMarginPayByAuctionId(int $auctionId) : int {
        return $this->getModel()
            ->where('type', 1)
            ->where('params', json_encode(['auction_id'=>$auctionId]))
            ->count();
    }

    public function addAuctionMargin(int $userId, int $auctionId, $amount) : int {
        return $this->add($userId, 2, ['auction_id'=>$auctionId], $amount);
    }

    public function add(int $userId, int $type, array $params, $amount) : int {
        return $this->getModel()->add([
            'user_id'   =>  $userId,
            'amount'    =>  $amount,
            'type'      =>  $type,
            'params'    =>  json_encode($params)
        ]);
    }

    public function addReturnDepositInUserId(array $userIds, int $auctionId, $amount) : int {
        foreach ($userIds as $userId){
            $this->add($userId, '3', ['auction_id'=>$auctionId], $amount);
        }
        return true;
    }

    public function recharge(int $userId, string $totalFee, string $openId){
        $params = $this->getOrderNumber();
        $this->add($userId, 1, $params, $totalFee);
        $orderNumber = $params['order_number'];
        return UserPayService::instance()->unify($userId, $openId, $orderNumber, $totalFee, 'deposit', '保证金充值 - '.$totalFee);
    }

    public function getOrderNumber($orderNumber = false, $array = true){
        if (!$orderNumber){
            $orderNumber = 'deposit'.date('YmdHis', time()).rand(1000, 9999);
        }
        $data = ['order_number'=>$orderNumber];
        return $array ? $data : json_encode($data);
    }

    public function notify(string $order_number){
        $order = $this->getModel()->where('params', $this->getOrderNumber($order_number, false))->first();
        if (!$order){
            throw new UserDepositServiceException('充值订单不存在');
        }
        if ($order->cz_status == 0){
            throw new UserDepositServiceException('充值订单已关闭');
        }
        if ($order->cz_status == 2){
            throw new UserDepositServiceException('订单已充值成功');
        }
        UserService::instance()->rechargeDeposit($order->user_id, $order->amount);
        return $this->getModel()->where('params', $this->getOrderNumber($order_number, false))->update([
            'cz_status'    =>  2,
        ]);
    }
}