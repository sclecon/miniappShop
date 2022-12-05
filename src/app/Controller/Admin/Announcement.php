<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\AnnouncementModel;
use App\Middleware\Admin\AuthenticationMiddleware;

/**
 * @ApiRouter(router="admin/announcement", method="get", intro="公告管理", middleware={AuthenticationMiddleware::class})
 */
class Announcement extends BaseCurd
{
    public function __construct()
    {
        $this->model = new AnnouncementModel();
        parent::__construct();
    }
}