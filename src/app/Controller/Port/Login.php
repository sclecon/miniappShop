<?php

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\BaseSupport\BaseSupportController;
use App\Services\UserService;
use App\Utils\WeChat;

/**
 * @ApiRouter(router="port/login", method="get", intro="用户登录")
 */
class Login extends BaseSupportController
{
    /**
     * @ApiRouter(router="url", method="get", intro="获取登录链接")
     * @Validator(attribute="target_url", required=true, rule="string", intro="回调地址")
     */
    public function getUrl(){
        $_SESSION['target_url'] = $this->request->input('target_url');
        var_dump(str_replace('url', 'index', $this->request->url()));
        $url = WeChat::app()->oauth->scopes(['snsapi_userinfo'])->redirect(str_replace('url', 'index', $this->request->url()))->getTargetUrl();
        return $this->success('获取登录链接成功', [
            'url'   =>  $url,
            'redirect_uri'  =>  str_replace('url', 'index', $this->request->url()),
        ]);
    }

    /**
     * @ApiRouter(router="index", method={"get", "post", "put"}, intro="执行登录请求")
     */
    public function index(){
        $user = WeChat::app()->oauth->user();
        $_SESSION['user'] = UserService::instance()->getUserInfo($user->getId(), $user->getName(), $user->getAvatar());
        $targetUrl = $_SESSION['target_url'] ?: '/';
        return $this->response->redirect($targetUrl);
    }

    /**
     * @ApiRouter(router="user/sign", method="get", intro="获取用户身份签名")
     */
    public function getUserSign(){
        if (!$_SESSION['user']){
            return $this->error('用户未登录账号');
        }
        $user = $_SESSION['user'];
        unset($_SESSION['user']);
        $sign = UserService::instance()->getUserSign($user);
        return $this->success('获取用户签名成功', [
            'sign'  =>  $sign,
            'user'  =>  $user
        ]);
    }
}