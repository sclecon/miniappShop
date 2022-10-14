<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Controller\Admin\Base\UploadImage;
use App\Model\ShopImageModel;

/**
 * @ApiRouter(router="admin/shop/image", method="get", intro="商品主图")
 */
class ShopImage extends UploadImage
{
    protected $moreFormData = true;
    protected $imageModule = 'shop';

    public function __construct()
    {
        $this->model = new ShopImageModel();
        parent::__construct();
    }
}