<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/10/24 17:49
 */

namespace App\Model;

use App\Model\BaseSupport\BaseSupportModel;

class UserAddressModel extends BaseSupportModel
{
    protected $table = 'user_address';

    protected $primaryKey = 'address_id';
}