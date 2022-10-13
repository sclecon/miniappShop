<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/10/13 17:54
 */

namespace App\Services;

use App\Model\ShopModel;
use App\Services\BaseSupport\BaseSupportService;

class ShopService extends BaseSupportService
{
    protected $model = ShopModel::class;
}