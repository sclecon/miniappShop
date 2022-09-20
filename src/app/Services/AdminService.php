<?php

namespace App\Services;

use App\Model\AdminModel;
use App\Services\BaseSupport\BaseSupportService;

class AdminService extends BaseSupportService
{

    protected $model = AdminModel::class;

    protected $salt = 'sclecon';

    public function adminLogin(string $username, string $password) : array {
        $password = $this->getPassWord($password);
        $admin = $this->getModel()
            ->where('username', $username)
            ->where('password', $password)
            ->select(['admin_id', 'username', 'intro', 'super'])
            ->first();
        return $admin ? $admin->toArray() : [];
    }

    protected function getPassWord(string $password) : string {
        return md5($password.$this->salt);
    }
}