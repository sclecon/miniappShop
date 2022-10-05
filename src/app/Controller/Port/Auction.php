<?php

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Controller\BaseSupport\BaseSupportController;
use App\Services\AuctionService;

/**
 * @ApiRouter(router="port/auction", method="get", intro="拍品相关")
 */
class Auction extends BaseSupportController
{
    /**
     * @ApiRouter(router="boutique", method="get", intro="获取精品拍品")
     */
    public function boutique(){
        $page = (int) $this->request->input('page', 1);
        $number = (int) $this->request->input('number', 50);
        return $this->success('获取精品拍品成功', [
            'list'  =>  AuctionService::instance()->getBoutique($page, $number),
        ]);
    }
}