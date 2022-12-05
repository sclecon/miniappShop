<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\UserModel;
use App\Middleware\Admin\AuthenticationMiddleware;

/**
 * @ApiRouter(router="admin/user", method="get", intro="用户管理", middleware={AuthenticationMiddleware::class})
 */
class User extends BaseCurd
{
    public function __construct()
    {
        $this->model = new UserModel();
        parent::__construct();
    }
}