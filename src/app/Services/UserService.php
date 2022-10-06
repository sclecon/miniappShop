<?php

namespace App\Services;

use App\Model\UserModel;
use App\Services\BaseSupport\BaseSupportService;
use App\Utils\Sign\PortUser;

class UserService extends BaseSupportService
{
    protected $model = UserModel::class;

    public function getUserInfo(string $openid, string $nickname, string $avatar) : array {
        $user = $this->getModel()
            ->where('openid', $openid)
            ->select(['user_id', 'avatar', 'username', 'intro', 'phone'])
            ->first();
        $user = $user->toArray();
        if (!$user){
            $user = $this->register($openid, $nickname, $avatar);
        }
        return $user;
    }

    protected function register(string $openid, string $nickname, string $avatar) : array {
        $user = [
            'openid'    =>  $openid,
            'username'  =>  $nickname,
            'avatar'    =>  $avatar,
            'intro'     =>  '',
            'phone'     =>  '',
        ];
        $user['user_id'] = $this->getModel()->add($user);
        unset($user['openid']);
        return $user;
    }

    public function getUserSign(array $userInfo) : string {
        return PortUser::instance()->encode($userInfo);
    }

    public function getUserInfoByUserId(int $userId) : array {
        return $this->getModel()->where('user_id', $userId)->first()->toArray();
    }
}