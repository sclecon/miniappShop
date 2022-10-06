<?php

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\BaseSupport\BaseSupportController;
use App\Services\AuctionJoinService;

/**
 * @ApiRouter(router="port/auction/join", method="get", intro="拍卖")
 */
class AuctionJoin extends BaseSupportController
{
    /**
     * @ApiRouter(router="add", method="put", intro="参与竞拍")
     * @Validator(attribute="auction_id", required=true, rule="integer", intro="拍品ID")
     * @Validator(attribute="join_price", required=true, rule="string", intro="竞拍价格")
     */
    public function add(){
        $user = $this->request->getAttribute('user');
        $userId = $user ? $user['user_id'] : 1;
        $auctionID = (int) $this->request->input('auction_id');
        $joinPrice = (string) $this->request->input('join_price');
        return $this->success('参与竞拍成功', [
            'join_id'   =>   AuctionJoinService::instance()->addJoin($userId, $auctionID, $joinPrice)
        ]);
    }

    /**
     * @ApiRouter(router="list", method="get", intro="竞拍记录")
     * @Validator(attribute="auction_id", required=true, rule="integer", intro="拍品ID")
     */
    public function list(){
        $auctionID = (int) $this->request->input('auction_id');
        return $this->success('获取竞拍出价记录成功', [
            'list'   =>   AuctionJoinService::instance()->joinList($auctionID)
        ]);
    }


}