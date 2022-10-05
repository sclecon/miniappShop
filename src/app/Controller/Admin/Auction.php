<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\AuctionModel;

/**
 * @ApiRouter(router="admin/auction", method="get", intro="拍品管理")
 */
class Auction extends BaseCurd
{
    public function __construct()
    {
        $this->model = new AuctionModel();
        parent::__construct();
    }
}