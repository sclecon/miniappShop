<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\AuctionLikeModel;

/**
 * @ApiRouter(router="admin/auction/like", method="get", intro="竞拍管理")
 */
class AuctionLike extends BaseCurd
{
    public function __construct()
    {
        $this->model = new AuctionLikeModel();
        parent::__construct();
    }
}