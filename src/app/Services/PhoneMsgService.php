<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/11/22 16:00
 */

namespace App\Services;

use App\Exception\Service\PhoneMsgServiceException;
use App\Model\PhoneMsgModel;
use App\Services\BaseSupport\BaseSupportService;
use App\Utils\AliyunSms;

class PhoneMsgService extends BaseSupportService
{
    protected $model = PhoneMsgModel::class;

    public function sendCode(string $phone) : int {
        $code = $this->createCode();
        $msg_id = $this->getModel()->add([
            'phone' =>  $phone,
            'code'  =>  $code,
        ]);
        if (!AliyunSms::instance()->sendCode($phone, $code)){
            throw new PhoneMsgServiceException('验证码发送失败');
        }
        return $msg_id;
    }

    public function verifyCode(string $phone, int $code, int $msgId) : int {
        $msg = $this->getModel()->where('phone', $phone)->where('code', $code)->where('msg_id', $msgId)->where('verify', 1)->first();
        if (!$msg){
            throw new PhoneMsgServiceException('验证码错误');
        }
        if ($msg->created_time+300 < time()){
            throw new PhoneMsgServiceException('验证码已过期');
        }
        return $msg->update(['verify'=>1]);
    }

    protected function createCode(int $length = 6) : int {
        $int = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $code = '';
        for ($i = 0; $i < $length; $i++){
            $code .= $int[rand(0, 9)];
        }
        return (int) $code;
    }
}