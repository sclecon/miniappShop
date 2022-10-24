<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/10/24 17:55
 */

namespace App\Services;

use App\Model\ShopOrderModel;
use App\Services\BaseSupport\BaseSupportService;

class ShopOrderService extends BaseSupportService
{
    protected $model = ShopOrderModel::class;
}