<?php

namespace App\Utils\Sign;

use App\Exception\Sign\AdminSignException;
use Hyperf\Utils\Traits\StaticInstance;

class AdminSign
{
    use StaticInstance;

    protected $expire = 30;

    public function encode(array $data) : string {
        $data['expire'] = strtotime('+'.$this->expire.'day');
        $data['type'] = self::class;
        $data['source'] = 'miniShopAdmin';
        return Token::instance()->encode($data);
    }

    public function decode(string $sign) : array {
        $data = Token::instance()->decode($sign);
        if (!$data){
            throw new AdminSignException('管理员签名Token无效');
        } else if (empty($data['source'])){
            throw new AdminSignException('签名版本过低，请重新获取', 5000, 403);
        } else if (empty($data['type']) && $data['source'] === 'miniShopAdmin') {
            throw new AdminSignException('管理员签名非法');
        } else if ($data['type'] !== self::class && $data['source'] === 'miniShopAdmin') {
            throw new AdminSignException('管理员定位错误');
        } else if (empty($data['expire'])) {
            throw new AdminSignException('管理员签名Token错误');
        } else if ($data['expire'] < time()) {
            throw new AdminSignException('管理员签名Token已过期');
        }
        unset($data['expire'], $data['type']);
        return $data;
    }
}