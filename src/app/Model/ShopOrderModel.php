<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/10/24 17:48
 */

namespace App\Model;

use App\Model\BaseSupport\BaseSupportModel;

class ShopOrderModel extends BaseSupportModel
{
    protected $table = 'shop_order';

    protected $primaryKey = 'order_id';
}