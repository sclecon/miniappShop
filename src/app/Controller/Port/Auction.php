<?php

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\BaseSupport\BaseSupportController;
use App\Services\AuctionService;

/**
 * @ApiRouter(router="port/auction", method="get", intro="拍品相关")
 */
class Auction extends BaseSupportController
{
    /**
     * @ApiRouter(router="boutique", method="get", intro="获取精品拍品")
     * @Validator(attribute="page", required=false, rule="integer", intro="分页")
     * @Validator(attribute="number", required=false, rule="integer", intro="显示数量")
     * @Validator(attribute="painter_id", required=false, rule="integer", intro="画家ID")
     */
    public function boutique(){
        $user = $this->request->getAttribute('user');
        $userId = $user ? $user['user_id'] : 1;
        $page = (int) $this->request->input('page', 1);
        $number = (int) $this->request->input('number', 50);
        $painterId = (int) $this->request->input('painter_id', 0);
        return $this->success('获取精品拍品成功', [
            'list'  =>  AuctionService::instance()->getBoutique($page, $number, $userId, $painterId),
        ]);
    }

    /**
     * @ApiRouter(router="list", method="get", intro="获取精品拍品列表")
     * @Validator(attribute="page", required=false, rule="integer", intro="分页")
     * @Validator(attribute="number", required=false, rule="integer", intro="显示数量")
     * @Validator(attribute="status", required=false, rule="integer", intro="拍卖状态 0=等待拍卖 1=拍卖中 2=拍卖结束")
     * @Validator(attribute="topic_id", required=false, rule="integer", intro="拍场ID")
     * @Validator(attribute="gallery", required=false, rule="integer", intro="是否画廊")
     * @Validator(attribute="orderby", required=false, rule="string", intro="排序字段")
     * @Validator(attribute="painter_id", required=false, rule="integer", intro="画家ID")
     */
    public function list(){
        $user = $this->request->getAttribute('user');
        $userId = $user ? $user['user_id'] : 1;
        $page = (int) $this->request->input('page', 1);
        $number = (int) $this->request->input('number', 50);
        $status = (int) $this->request->input('status', -1);
        $topicId = (int) $this->request->input('topic_id', -1);
        $gallery = (int) $this->request->input('gallery', -1);
        $orderBy = (string) $this->request->input('orderby', 'auction_id');
        $painterId = (int) $this->request->input('painter_id', 0);
        return $this->success('获取列表成功', [
            'list'  =>  AuctionService::instance()->list($page, $number, $status, $topicId, $gallery, $orderBy, $userId, $painterId),
        ]);
    }

    /**
     * @ApiRouter(router="detail", method="get", intro="获取拍品详情")
     * @Validator(attribute="auction_id", required=true, rule="integer", intro="拍品ID")
     */
    public function detail(){
        $user = $this->request->getAttribute('user');
        $userId = $user ? $user['user_id'] : 1;
        $auctionId = (int) $this->request->input('auction_id');
        return $this->success('获取详情成功', AuctionService::instance()->detail($auctionId, $userId));
    }
}