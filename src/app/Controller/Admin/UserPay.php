<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/11/2 17:54
 */

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\UserPayModel;
use App\Middleware\Admin\AuthenticationMiddleware;

/**
 * @ApiRouter(router="admin/user/pay", method="get", intro="支付管理", middleware={AuthenticationMiddleware::class})
 */
class UserPay extends BaseCurd
{
    public function __construct()
    {
        $this->model = new UserPayModel();
        parent::__construct();
    }
}