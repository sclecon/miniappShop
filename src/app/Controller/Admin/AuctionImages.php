<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Controller\Admin\Base\UploadImage;
use App\Model\AuctionImageModel;
use App\Middleware\Admin\AuthenticationMiddleware;

/**
 * @ApiRouter(router="admin/auction/images", method="get", intro="拍品图片", middleware={AuthenticationMiddleware::class})
 */
class AuctionImages extends UploadImage
{
    protected $moreFormData = true;
    protected $imageModule = 'auction';


    public function __construct()
    {
        $this->model = new AuctionImageModel();
        parent::__construct();
    }
}