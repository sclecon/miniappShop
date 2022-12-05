<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/10/24 17:50
 */

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\UserAddressModel;
use App\Middleware\Admin\AuthenticationMiddleware;

/**
 * @ApiRouter(router="admin/user/address", method="get", intro="用户收货地址管理", middleware={AuthenticationMiddleware::class})
 */
class UserAddress extends BaseCurd
{
    public function __construct()
    {
        $this->model = new UserAddressModel();
        parent::__construct();
    }
}