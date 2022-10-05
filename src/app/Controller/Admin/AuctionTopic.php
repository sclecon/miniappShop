<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\BannerModel;
use App\Utils\Image;

/**
 * @ApiRouter(router="admin/auction/topic", method="get", intro="拍品拍场")
 */
class AuctionTopic extends BaseCurd
{
    public function __construct()
    {
        $this->model = new BannerModel();
        parent::__construct();
    }
}