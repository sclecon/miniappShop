<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\AuctionTopicModel;

/**
 * @ApiRouter(router="admin/auction/topic", method="get", intro="拍品拍场")
 */
class AuctionTopic extends BaseCurd
{
    public function __construct()
    {
        $this->model = new AuctionTopicModel();
        parent::__construct();
    }
}