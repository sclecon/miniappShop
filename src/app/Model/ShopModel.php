<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/10/13 17:53
 */

namespace App\Model;

use App\Model\BaseSupport\BaseSupportModel;

class ShopModel extends BaseSupportModel
{
    protected $table = 'shop';

    protected $primaryKey = 'shop_id';
}