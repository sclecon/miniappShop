<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/10/24 17:55
 */

namespace App\Services;

use App\Model\UserAddressModel;
use App\Services\BaseSupport\BaseSupportService;

class UserAddressService extends BaseSupportService
{
    protected $model = UserAddressModel::class;
}