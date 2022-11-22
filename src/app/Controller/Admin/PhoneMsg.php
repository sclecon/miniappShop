<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/11/22 15:59
 */

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\PhoneMsgModel;

/**
 * @ApiRouter(router="admin/phone/msg", method="get", intro="手机验证码管理")
 */
class PhoneMsg extends BaseCurd
{
    public function __construct()
    {
        $this->model = new PhoneMsgModel();
        parent::__construct();
    }
}