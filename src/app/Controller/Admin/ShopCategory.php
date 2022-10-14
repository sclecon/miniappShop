<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Controller\Admin\Base\UploadImage;
use App\Model\ShopCategoryModel;

/**
 * @ApiRouter(router="admin/shop/category", method="get", intro="商品分类")
 */
class ShopCategory extends UploadImage
{

    protected $moreFormData = true;
    protected $imageModule = 'shop/category';


    public function __construct()
    {
        $this->model = new ShopCategoryModel();
        parent::__construct();
    }
}