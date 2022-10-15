<?php

namespace App\Services;

use App\Exception\Service\AuctionJoinServiceException;
use App\Model\AuctionJoinModel;
use App\Services\BaseSupport\BaseSupportService;

class AuctionJoinService extends BaseSupportService
{
    protected $model = AuctionJoinModel::class;

    public function addJoin(int $userId, int $auctionId, string $joinPrice) : int {
        $auction = AuctionService::instance()->detail($auctionId,$userId);
        if ($auction['status'] != 1){
            throw new AuctionJoinServiceException('拍品当前状态无法进行参与竞拍');
        }
        if ($auction['start_price'] >= $joinPrice){
            throw new AuctionJoinServiceException('竞拍出价不能低于起拍价');
        }
        $user = UserService::instance()->getUserInfoByUserId($userId);
        if (!$user){
            throw new AuctionJoinServiceException('用户不存在');
        }
        return $this->getModel()->add([
            'auction_id'        =>  $auctionId,
            'avatar'            => $user['avatar'],
            'user_id'           => $userId,
            'join_price'        => $joinPrice,
            'status'            =>  1,
        ]);
    }

    public function joinList(int $auctionId){
        $list = $this->getModel()
            ->where('auction_id', $auctionId)
            ->select(['join_id', 'auction_id', 'avatar', 'user_id', 'join_price', 'status', 'created_time'])
            ->orderByDesc('join_id')
            ->get()
            ->toArray();
        foreach ($list as $key => $value){
            $value['created_time'] = date('Y-m-d H:i:s', $value['created_time']);
            $list[$key] = $value;
        }
        return $list;
    }
}