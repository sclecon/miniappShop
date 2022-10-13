<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/10/13 17:54
 */

namespace App\Services;

use App\Model\ShopImageModel;
use App\Services\BaseSupport\BaseSupportService;

class ShopImageService extends BaseSupportService
{
    protected $model = ShopImageModel::class;
}