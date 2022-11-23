<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/11/22 15:58
 */

namespace App\Model;

use App\Model\BaseSupport\BaseSupportModel;

class PhoneMsgModel extends BaseSupportModel
{
    protected $table = 'phone_msg';

    protected $primaryKey = 'msg_id';

    protected $fillable = ['status'];
}