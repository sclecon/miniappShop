<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Controller\Admin\Base\UploadImage;
use App\Model\BannerModel;
use App\Middleware\Admin\AuthenticationMiddleware;

/**
 * @ApiRouter(router="admin/banner", method="get", intro="首页Banner轮播图", middleware={AuthenticationMiddleware::class})
 */
class Banner extends UploadImage
{
    protected $imageModule = 'banner';

    public function __construct()
    {
        $this->model = new BannerModel();
        parent::__construct();
    }
}