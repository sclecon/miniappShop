<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/11/1 17:44
 */

namespace App\Model;

use App\Model\BaseSupport\BaseSupportModel;

class UserDepositModel extends BaseSupportModel
{
    protected $table = 'user_deposit';

    protected $primaryKey = 'deposit_id';
}