<?php

namespace App\Utils\Sign;

use App\Exception\Sign\PortUserException;
use App\Services\UserService;
use Hyperf\Utils\Traits\StaticInstance;

class PortUser
{
    use StaticInstance;

    protected $expire = 30;

    public function encode(int $userId, int $ucUserId) : string {
        $data = [
            'user_id'       =>  $userId,
            'uc_user_id'    =>  $ucUserId,
            'expire'        =>  strtotime('+'.$this->expire.'day'),
            'type'          =>  self::class,
            'source'        =>  'sumodPro'
        ];
        return Token::instance()->encode($data);
    }

    public function decode(string $sign) : array {
        $data = Token::instance()->decode($sign);
        if (!$data){
            throw new PortUserException('用户签名Token无效');
        } else if (empty($data['source'])){
            throw new PortUserException('Token版本过低，请重新获取', 5000, 403);
        } else if (empty($data['type']) && $data['source'] === 'sumodPro') {
            throw new PortUserException('用户签名非法');
        } else if ($data['type'] !== self::class && $data['source'] === 'sumodPro') {
            throw new PortUserException('签名定位错误');
        } else if (empty($data['expire'])) {
            throw new PortUserException('用户签名Token错误');
        } else if ($data['expire'] < time()) {
            throw new PortUserException('用户签名Token已过期');
        }
        unset($data['expire'], $data['type']);
        return $data['source'] !== 'sumodPro' ? $this->format($data) : $data;
    }

    protected function format(array $data) : array {
        if (isset($data['uc_user_id'])){
            $data['user_id'] = UserService::instance()->getUserIdByUcUserId($data['uc_user_id']);
        }else{
            throw new PortUserException('缺少参数ucid');
        }
        return $data;
    }
}