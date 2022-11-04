<?php

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\BaseSupport\BaseSupportController;
use App\Services\UserService;
use App\Utils\WeChat;
use Hyperf\HttpServer\Response;
use Hyperf\Utils\ApplicationContext;

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
        $redirect = strtolower(str_replace('url', 'index', $this->request->url()));
        $url = WeChat::app()->oauth->scopes(['snsapi_userinfo'])->redirect($redirect)->getTargetUrl();
        return ApplicationContext::getContainer()->get(Response::class)->redirect($url);
        return $this->success('获取登录链接成功', [
            'url'   =>  $url,
            'redirect_uri'  =>  $redirect,
        ]);
    }

    /**
     * @ApiRouter(router="index", method={"get", "post", "put"}, intro="执行登录请求")
     */
    public function index(){
        $_POST['code'] = $_GET['code'] = $this->request->input('code', '');
        $_POST['state'] = $_GET['state'] = $this->request->input('state', '');
        var_dump($_GET);

        $user = WeChat::app()->oauth->user();
        $_SESSION['user'] = UserService::instance()->getUserInfo($user->getId(), $user->getName(), $user->getAvatar());
        $targetUrl = isset($_SESSION['target_url']) ? $_SESSION['target_url']: '/';
        return ApplicationContext::getContainer()->get(Response::class)->redirect($targetUrl);
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
        unset($user['openid']);
        return $this->success('获取用户签名成功', [
            'sign'  =>  $sign,
            'user'  =>  $user
        ]);
    }
}