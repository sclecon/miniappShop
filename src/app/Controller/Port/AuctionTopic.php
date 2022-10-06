<?php

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\BaseSupport\BaseSupportController;
use App\Services\AuctionTopicService;

/**
 * @ApiRouter(router="port/auction/topic", method="get", intro="拍场")
 */
class AuctionTopic extends BaseSupportController
{
    /**
     * @ApiRouter(router="boutique", method="get", intro="获取精品拍场")
     * @Validator(attribute="page", required=false, rule="integer", intro="分页")
     * @Validator(attribute="number", required=false, rule="integer", intro="显示数量")
     */
    public function boutique(){
        $page = (int) $this->request->input('page', 1);
        $number = (int) $this->request->input('number', 50);
        return $this->success('获取精品拍场成功', [
            'list'  =>  AuctionTopicService::instance()->getBoutique($page, $number)
        ]);
    }

    /**
     * @ApiRouter(router="list", method="get", intro="获取拍场列表")
     * @Validator(attribute="page", required=false, rule="integer", intro="分页")
     * @Validator(attribute="number", required=false, rule="integer", intro="显示数量")
     */
    public function list(){
        $page = (int) $this->request->input('page', 1);
        $number = (int) $this->request->input('number', 50);
        $status = (int) $this->request->input('status', -1);
        return $this->success('获取列表成功', [
            'list'  =>  AuctionTopicService::instance()->list($page, $number, $status),
        ]);
    }

    /**
     * @ApiRouter(router="detail", method="get", intro="获取拍场详情")
     * @Validator(attribute="topic_id", required=true, rule="integer", intro="拍场ID")
     */
    public function detail(){
        $topicId = (int) $this->request->input('topic_id');
        return $this->success('获取详情成功', AuctionTopicService::instance()->detail($topicId));
    }
}