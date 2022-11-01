<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/11/1 17:46
 */

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\UserDepositModel;

/**
 * @ApiRouter(router="admin/user/deposit", method="get", intro="用户保证金变动记录")
 */
class UserDeposit extends BaseCurd
{
    public function __construct()
    {
        $this->model = new UserDepositModel();
        parent::__construct();
    }
}