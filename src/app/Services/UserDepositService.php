<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/11/1 17:45
 */

namespace App\Services;

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
}