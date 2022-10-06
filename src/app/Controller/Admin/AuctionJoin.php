<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\AuctionJoinModel;

/**
 * @ApiRouter(router="admin/auction/join", method="get", intro="竞拍管理")
 */
class AuctionJoin extends BaseCurd
{
    public function __construct()
    {
        $this->model = new AuctionJoinModel();
        parent::__construct();
    }
}