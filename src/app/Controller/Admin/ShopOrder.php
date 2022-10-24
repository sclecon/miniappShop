<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/10/24 17:53
 */

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\ShopOrderModel;

/**
 * @ApiRouter(router="admin/shop/order", method="get", intro="商品订单管理")
 */
class ShopOrder extends BaseCurd
{

    public function __construct()
    {
        $this->model = new ShopOrderModel();
        parent::__construct();
    }
}