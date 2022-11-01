<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/11/1 17:45
 */

namespace App\Services;

use App\Model\UserDepositModel;
use App\Services\BaseSupport\BaseSupportService;
use App\Utils\ArrayExpand;

class UserDepositService extends BaseSupportService
{
    protected $model = UserDepositModel::class;

    public function list(int $userId, int $type, int $page, int $number) : array {
        $model = $this->getModel()->where('user_id', $userId);
        if ($type){
            $model = $model->where('type', $type);
        }
        $model = $model->forPage($page, $number);
        $list = $model->get()->toArray();
        foreach ($list as $key => $value){
            $list[$key]['ymd'] = date('Y-m-d', $value['created_time']);
        }
        return ArrayExpand::columns($list, 'ymd', 'deposit_id');
    }
}