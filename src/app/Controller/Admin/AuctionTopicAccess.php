<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\AuctionTopicAccessModel;

/**
 * @ApiRouter(router="admin/auction/topic/access", method="get", intro="拍场内拍品管理")
 */
class AuctionTopicAccess extends BaseCurd
{

    public function __construct()
    {
        $this->model = new AuctionTopicAccessModel();
        parent::__construct();
    }
}