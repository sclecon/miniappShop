<?php

namespace App\Utils\Sign;

use App\Exception\Sign\PortUserException;
use App\Services\UserService;
use Hyperf\Utils\Traits\StaticInstance;

class PortUser
{
    use StaticInstance;

    protected $expire = 30;

    public function encode(array $data) : string {
        $data['expire'] = strtotime('+'.$this->expire.'day');
        $data['type'] = self::class;
        $data['source'] = 'miniShop';
        return Token::instance()->encode($data);
    }

    public function decode(string $sign) : array {
        $data = Token::instance()->decode($sign);
        if (!$data){
            throw new PortUserException('用户签名Token无效');
        } else if (empty($data['source'])){
            throw new PortUserException('Token版本过低，请重新获取', 5000, 403);
        } else if (empty($data['type']) && $data['source'] === 'miniShop') {
            throw new PortUserException('用户签名非法');
        } else if ($data['type'] !== self::class && $data['source'] === 'miniShop') {
            throw new PortUserException('签名定位错误');
        } else if (empty($data['expire'])) {
            throw new PortUserException('用户签名Token错误');
        } else if ($data['expire'] < time()) {
            throw new PortUserException('用户签名Token已过期');
        }
        unset($data['expire'], $data['type']);
        return $data;
    }
}