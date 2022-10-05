<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\BannerModel;

/**
 * @ApiRouter(router="admin/announcement", method="get", intro="公告管理")
 */
class Announcement extends BaseCurd
{
    public function __construct()
    {
        $this->model = new BannerModel();
        parent::__construct();
    }
}