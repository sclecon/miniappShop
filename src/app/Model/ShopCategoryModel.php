<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/10/13 17:52
 */

namespace App\Model;

use App\Model\BaseSupport\BaseSupportModel;

class ShopCategoryModel extends BaseSupportModel
{
    protected $table = 'shop_category';

    protected $primaryKey = 'category_id';
}