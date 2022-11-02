<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/11/2 17:52
 */

namespace App\Model;

use App\Model\BaseSupport\BaseSupportModel;

class UserPayModel extends BaseSupportModel
{
    protected $table = 'user_pay';

    protected $primaryKey = 'pay_id';
}