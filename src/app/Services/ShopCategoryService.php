<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/10/13 17:54
 */

namespace App\Services;

use App\Model\ShopCategoryModel;
use App\Services\BaseSupport\BaseSupportService;

class ShopCategoryService extends BaseSupportService
{
    protected $model = ShopCategoryModel::class;
}