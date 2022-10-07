<?php

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\BaseSupport\BaseSupportController;
use App\Services\AuctionLikeService;

/**
 * @ApiRouter(router="port/auction/like", method="get", intro="拍品喜欢")
 */
class AuctionLike extends BaseSupportController
{
    /**
     * @ApiRouter(router="add", method="put", intro="添加喜欢")
     * @Validator(attribute="auction_id", required=true, rule="integer", intro="拍品ID")
     */
    public function add(){
        $user = $this->request->getAttribute('user');
        $userId = $user ? $user['user_id'] : 1;
        $auctionID = (int) $this->request->input('auction_id');
        $response = AuctionLikeService::instance()->like($userId, $auctionID);
        return is_bool($response) ? $this->success('取消点赞成功') : $this->success('点赞成功');
    }

    /**
     * @ApiRouter(router="list", method="get", intro="获取喜欢记录")
     * @Validator(attribute="auction_id", required=true, rule="integer", intro="拍品ID")
     */
    public function list(){
        $auctionID = (int) $this->request->input('auction_id');
        return $this->success('获取点赞记录成功', [
            'list'   =>   AuctionLikeService::instance()->likeList($auctionID)
        ]);
    }


}