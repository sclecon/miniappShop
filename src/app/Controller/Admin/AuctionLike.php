<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\AuctionLikeModel;
use App\Middleware\Admin\AuthenticationMiddleware;

/**
 * @ApiRouter(router="admin/auction/like", method="get", intro="竞拍管理", middleware={AuthenticationMiddleware::class})
 */
class AuctionLike extends BaseCurd
{
    public function __construct()
    {
        $this->model = new AuctionLikeModel();
        parent::__construct();
    }
}