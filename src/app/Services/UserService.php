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
            ->select(['user_id', 'avatar', 'username', 'intro', 'phone', 'openid'])
            ->first();
        return $user ? $user->toArray() : $this->register($openid, $nickname, $avatar);
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
        return $user;
    }

    public function getUserSign(array $userInfo) : string {
        return PortUser::instance()->encode($userInfo);
    }

    public function getUserInfoByUserId(int $userId) : array {
        return $this->getModel()->where('user_id', $userId)->first()->toArray();
    }

    public function getUserDepositInfo(int $userId) : array {
        return $this->getModel()
            ->where('user_id', $userId)
            ->select(['deposit', 'freeze_deposit'])
            ->first()
            ->toArray();
    }

    public function depositPay(int $userId, int $auctionId, $deposit) : int {
        $response = $this->getModel()
            ->where('user_id', $userId)
            ->update([
                'deposit'           =>      'deposit - '.$deposit,
                'freeze_deposit'    =>      'freeze_deposit + '.$deposit
            ]);
        UserDepositService::instance()->addAuctionMargin($userId, $auctionId, $deposit);
        return $response;
    }

    public function depositReturnInUserIds(array $userIds, int $auctionId, $deposit){
        $response = $this->getModel()->whereIn('user_id', $userIds)->update([
            'deposit'           =>      'deposit + '.$deposit,
            'freeze_deposit'    =>      'freeze_deposit - '.$deposit
        ]);
        UserDepositService::instance()->addReturnDepositInUserId($userIds, $auctionId, $deposit);
        return $response;
    }

    public function hasUserByPhone(string $phone) : int {
        return (int) $this->getModel()->where('phone', $phone)->value('user_id');
    }

    public function bindPhone(int $userId, int $phone){
        return $this->getModel()->where('user_id', $userId)->update(['phone'=>$phone]);
    }

    public function getUserPhone(int $userId) : string {
        return (string) $this->getModel()->where('user_id', $userId)->value('phone');
    }
}