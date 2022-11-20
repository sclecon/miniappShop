<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\AuctionOrderModel;

/**
 * @ApiRouter(router="admin/auction/order", method="get", intro="拍品订单")
 */
class AuctionOrder extends BaseCurd
{
    public function __construct()
    {
        $this->model = new AuctionOrderModel();
        parent::__construct();
    }
}