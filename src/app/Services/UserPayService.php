<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/11/2 17:54
 */

namespace App\Services;

use App\Model\UserPayModel;
use App\Services\BaseSupport\BaseSupportService;

class UserPayService extends BaseSupportService
{
    protected $model = UserPayModel::class;
}