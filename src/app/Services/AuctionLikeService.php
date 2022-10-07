<?php

namespace App\Services;

use App\Model\AuctionLikeModel;
use App\Services\BaseSupport\BaseSupportService;
use App\Utils\ArrayExpand;

class AuctionLikeService extends BaseSupportService
{
    protected $model = AuctionLikeModel::class;

    public function like(int $userId, int $auctionId){
        if ($likeId = $this->has($userId, [$auctionId])[$auctionId]){
            return $this->removeLike((int) $likeId);
        }else{
            return $this->addLike($userId, $auctionId);
        }
    }

    public function has(int $userId, array $auctionIds) : array {
        $has = $this->getModel()
            ->whereIn('auction_id', $auctionIds)
            ->where('user_id', $userId)
            ->select(['like_id', 'auction_id'])
            ->get()
            ->toArray();
        $has = ArrayExpand::columnKey($has, 'auction_id', 'like_id');
        $list = [];
        foreach ($auctionIds as $auction_id){
            $list[$auction_id] = isset($has[$auction_id]) ? $has[$auction_id] : 0;
        }
        return $list;
    }

    public function addLike(int $userId, int $auctionId) : int {
        $user = UserService::instance()->getUserInfoByUserId($userId);
        return $this->getModel()->add([
            'auction_id'    =>  $auctionId,
            'user_id'       =>  $userId,
            'username'      =>  $user['username'],
            'avatar'        =>  $user['avatar'],
        ]);
    }

    public function removeLike(int $likeId) : bool {
        return (bool) $this->getModel()->where('like_id', $likeId)->delete();
    }

    public function likeList(int $auctionId) : array {
        return $this->getModel()
            ->where('auction_id', $auctionId)
            ->select(['auction_id', 'like_id', 'username', 'avatar'])
            ->get()
            ->toArray();
    }
}