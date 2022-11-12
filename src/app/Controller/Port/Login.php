<?php

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\BaseSupport\BaseSupportController;
use App\Services\UserService;
use App\Utils\WeChat;
use Hyperf\Contract\SessionInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Response;
use Hyperf\Utils\ApplicationContext;

/**
 * @ApiRouter(router="port/login", method="get", intro="用户登录")
 */
class Login extends BaseSupportController
{


    /**
     * @Inject()
     * @var SessionInterface
     */
    protected $session;

    /**
     * @ApiRouter(router="url", method="get", intro="获取登录链接")
     * @Validator(attribute="target_url", required=true, rule="string", intro="回调地址")
     */
    public function getUrl(){
        $this->session->set('target_url', $this->request->input('target_url', '/'));
        $redirect = strtolower(str_replace('url', 'index', $this->request->url()));
        var_dump($redirect);
        $url = WeChat::app()->oauth->scopes(['snsapi_userinfo'])->redirect($redirect)->getTargetUrl();
        return ApplicationContext::getContainer()->get(Response::class)->redirect($url);
    }

    /**
     * @ApiRouter(router="index", method={"get", "post", "put"}, intro="执行登录请求")
     */
    public function index(){

        $code = $this->request->input('code', false);
        if ($code === false){
            return $this->error('无有效参数');
        }

        $user = WeChat::app()->oauth->user($code);
        $this->session->set('user', UserService::instance()->getUserInfo($user->getId(), $user->getName(), $user->getAvatar()));
        $targetUrl = $this->session->get('target_url', '/');
        return ApplicationContext::getContainer()->get(Response::class)->redirect($targetUrl);
    }

    /**
     * @ApiRouter(router="user/sign", method="get", intro="获取用户身份签名")
     */
    public function getUserSign(){
        $user = $this->session->get('user', []);
        if (!$user){
            return $this->error('用户未登录账号');
        }
        $this->session->remove('user');
        $sign = UserService::instance()->getUserSign($user);
        unset($user['openid']);
        return $this->success('获取用户签名成功', [
            'sign'  =>  $sign,
            'user'  =>  $user
        ]);
    }
}