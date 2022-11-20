<?php

namespace App\Services;

use App\Exception\Service\AuctionJoinServiceException;
use App\Model\AuctionJoinModel;
use App\Services\BaseSupport\BaseSupportService;
use App\Utils\ArrayExpand;
use App\Utils\Http;

class AuctionJoinService extends BaseSupportService
{
    protected $model = AuctionJoinModel::class;

    public function addJoin(int $userId, int $auctionId, string $joinPrice) : int {
        $auction = AuctionService::instance()->detail($auctionId,$userId);
        if ($auction['status'] != 1){
            throw new AuctionJoinServiceException('拍品当前状态无法进行参与竞拍');
        }
        if (!$auction['this_price'] && $auction['start_price'] >= $joinPrice){
            throw new AuctionJoinServiceException('竞拍出价不能低于起拍价');
        } else if ($auction['this_price'] && $auction['this_price'] >= $joinPrice){
            throw new AuctionJoinServiceException('竞拍出价不能低于当前竞拍价');
        } else if ($joinPrice < $auction['append_price']){
            throw new AuctionJoinServiceException('竞拍加价单次不得小于'.$auction['append_price'].'元');
        }
        $user = UserService::instance()->getUserInfoByUserId($userId);
        if (!$user){
            throw new AuctionJoinServiceException('用户不存在');
        }

        // 保证金暂定 100
        $margin = 1000;

        // 判断当前用户是否已经缴纳保证金

        if ($user['deposit'] < $margin){
            throw new AuctionJoinServiceException('您账户当前保证金不足'.$margin.', 无法参与竞拍');
        }


        $joinId = $this->getModel()->add([
            'auction_id'        =>  $auctionId,
            'avatar'            => $user['avatar'],
            'user_id'           => $userId,
            'join_price'        => $joinPrice,
            'status'            =>  1,
        ]);
        AuctionService::instance()->upgradeThisPrice($auctionId, $joinPrice);

        return $joinId;
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

    public function userJoinList(int $userId, int $status, int $page, int $number){
        $auction = AuctionService::instance()->getModel();
        $auctionImage = AuctionImageService::instance()->getModel();
        $list = $this->getModel()
            ->where($this->getModel()->getTableKey('user_id'), $userId);
        if ($status != 999){
            $list = $list->where($this->getModel()->getTableKey('status'), $status);
        }
        $list = $list->orderByDesc($this->getModel()->getTableKey('join_id'))
            ->forPage($page, $number)
            ->select([
                $this->getModel()->getTableKey('*'),
            ])
            ->get()
            ->toArray();
        $auctionId = ArrayExpand::getKeys($list, 'auction_id');
        $auctionNames = AuctionService::instance()->getAuctionListInAuctionIds($auctionId);
        foreach ($list as $key => $value){
            $value['created_time'] = date('Y-m-d H:i:s', $value['created_time']);
            $value['auction'] = isset($auctionNames[$value['auction_id']]) ? $auctionNames[$value['auction_id']] : [];
            $list[$key] = $value;
        }
        return $list;
    }

    public function getAllJoinByAuctionIds(array $allAuctionIds) : array {
        $list = $this->getModel()
            ->whereIn('auction_id', $allAuctionIds)
            ->select(['join_id', 'auction_id', 'user_id', 'join_price'])
            ->get();
        $list = $list ? $list->toArray() : [];
        return ArrayExpand::columns($list, 'auction_id', 'join_id');
    }

    public function openJoin(){
        $allAuctions = AuctionService::instance()->getIsCanLotteryAuctions();
        $allJoin = $this->getAllJoinByAuctionIds(array_keys($allAuctions));
        foreach ($allJoin as $auctionId => $joins){
            $joins = ArrayExpand::column($joins, 'join_price');
            krsort($joins);
            $userJoins = reset($joins);
            $userid = $userJoins['user_id'];
//            foreach ($joins as $join){
//
//            }
        }
    }
}