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
     */
    public function boutique(){
        $page = (int) $this->request->input('page', 1);
        $number = (int) $this->request->input('number', 50);
        return $this->success('获取精品拍品成功', [
            'list'  =>  AuctionService::instance()->getBoutique($page, $number),
        ]);
    }

    /**
     * @ApiRouter(router="list", method="get", intro="获取精品拍品列表")
     * @Validator(attribute="page", required=false, rule="integer", intro="分页")
     * @Validator(attribute="number", required=false, rule="integer", intro="显示数量")
     * @Validator(attribute="status", required=false, rule="integer", intro="拍卖状态 0=等待拍卖 1=拍卖中 2=拍卖结束")
     */
    public function list(){
        $page = (int) $this->request->input('page', 1);
        $number = (int) $this->request->input('number', 50);
        $status = (int) $this->request->input('status', -1);
        return $this->success('获取列表成功', [
            'list'  =>  AuctionService::instance()->list($page, $number, $status),
        ]);
    }
}