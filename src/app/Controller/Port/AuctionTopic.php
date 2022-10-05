<?php

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Controller\BaseSupport\BaseSupportController;
use App\Services\AuctionTopicService;

/**
 * @ApiRouter(router="port/auction/topic", method="get", intro="拍场")
 */
class AuctionTopic extends BaseSupportController
{
    /**
     * @ApiRouter(router="boutique", method="get", intro="获取精品拍场")
     */
    public function boutique(){
        $page = (int) $this->request->input('page', 1);
        $number = (int) $this->request->input('number', 50);
        return $this->success('获取精品拍场成功', [
            'list'  =>  AuctionTopicService::instance()->getBoutique($page, $number)
        ]);
    }
}