<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\BaseSupport\BaseSupportController;
use App\Services\AdminService;
use App\Utils\Sign\AdminSign;

/**
 * @ApiRouter(router="admin/login", method="get", intro="管理员登录")
 */
class Admin extends BaseSupportController
{
    /**
     * @ApiRouter(router="index", method="post", intro="登录校验")
     * @Validator(attribute="username", required=true, rule="string", intro="用户名")
     * @Validator(attribute="password", required=true, rule="string", intro="密码")
     */
    public function login(){
        $username = $this->request->input('username');
        $password = $this->request->input('password');
        $adminer = AdminService::instance()->adminLogin($username, $password);
        if (!$adminer){
            return $this->error('账号或密码错误');
        }
        return $this->success('管理员登录成功', [
            'sign'      =>  AdminSign::instance()->encode($adminer),
            'adminer'   =>  $adminer,
        ]);
    }
}