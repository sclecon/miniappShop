<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\ShopModel;

/**
 * @ApiRouter(router="admin/shop", method="get", intro="商品管理")
 */
class Shop extends BaseCurd
{
    public function __construct()
    {
        $this->model = new ShopModel();
        parent::__construct();
    }
}