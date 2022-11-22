<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/11/1 17:12
 */

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\BaseSupport\BaseSupportController;
use App\Services\AuctionJoinService;
use App\Services\PhoneMsgService;
use App\Services\UserDepositService;
use App\Services\UserService;
use App\Middleware\User\AuthenticationMiddleware;

/**
 * @ApiRouter(router="port/user", method="get", intro="用户相关", middleware={AuthenticationMiddleware::class})
 */
class User extends BaseSupportController
{

    /**
     * @ApiRouter(router="deposit", method="get", intro="获取用户保证金")
     */
    public function deposit(){
        $userId = $this->getAuthUserId();
        return $this->success('获取保证金成功', UserService::instance()->getUserDepositInfo($userId));
    }

    /**
     * @ApiRouter(router="deposit/log", method="get", intro="保证金收支记录")
     * @Validator(attribute="type", required=false, rule="integer", intro="记录类型")
     * @Validator(attribute="page", required=false, rule="integer", intro="分页")
     * @Validator(attribute="number", required=false, rule="integer", intro="每页数量")
     */
    public function depositlog(){
        $userId = $this->getAuthUserId();
        $page = (int) $this->request->input('page', 1);
        $number = (int) $this->request->input('number', 20);
        $type = (int) $this->request->input('type', 0);
        return $this->success('获取记录成功', [
            'list'  =>  UserDepositService::instance()->list($userId, $type, $page, $number)
        ]);
    }

    /**
     * @ApiRouter(router="auction/join/list", method="get", intro="我的竞拍记录")
     * @Validator(attribute="status", required=false, rule="integer", intro="竞拍结果状态")
     * @Validator(attribute="page", required=false, rule="integer", intro="分页")
     * @Validator(attribute="number", required=false, rule="integer", intro="每页数量")
     */
    public function list(){
        $userId = $this->getAuthUserId();
        $status = (int) $this->request->input('status', 999);
        $page = (int) $this->request->input('page', 1);
        $number = (int) $this->request->input('number', 20);
        return $this->success('获取我的竞拍记录成功', [
            'list'   =>   AuctionJoinService::instance()->userJoinList($userId, $status, $page, $number)
        ]);
    }

    /**
     * @ApiRouter(router="phone/send", method="get", intro="发送验证码绑定手机")
     * @Validator(attribute="phone", required=true, rule="string", intro="手机号")
     */
    public function sendCode(){
        $phone = $this->request->input('phone');
        if (UserService::instance()->hasUserByPhone($phone)){
            return  $this->error('该手机号已绑定其他账号，请勿重复绑定');
        }
        return $this->success('发送验证码成功', [
            'msg_id'    =>  PhoneMsgService::instance()->sendCode($phone),
        ]);
    }

    /**
     * @ApiRouter(router="phone/verify", method="get", intro="验证")
     * @Validator(attribute="phone", required=true, rule="string", intro="手机号")
     * @Validator(attribute="msg_id", required=true, rule="integer", intro="验证码ID")
     * @Validator(attribute="code", required=true, rule="integer", intro="验证码")
     */
    public function check(){
        $phone = $this->request->input('phone');
        $msgId = (int) $this->request->input('msg_id');
        $code = (int) $this->request->input('code');
        $verifyFlag = PhoneMsgService::instance()->verifyCode($phone, $code, $msgId);
        if ($verifyFlag){
            $userId = $this->getAuthUserId();
            UserService::instance()->bindPhone($userId, $phone);
        }
        return $verifyFlag ? $this->success('绑定手机号成功') : $this->error('绑定手机号失败');
    }
}