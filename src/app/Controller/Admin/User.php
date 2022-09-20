<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\UserModel;

/**
 * @ApiRouter(router="admin/user", method="get", intro="用户管理")
 */
class User extends BaseCurd
{
    public function __construct()
    {
        $this->model = new UserModel();
        parent::__construct();
    }
}