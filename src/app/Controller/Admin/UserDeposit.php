<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/11/1 17:46
 */

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\UserDepositModel;
use App\Services\UserService;

/**
 * @ApiRouter(router="admin/user/deposit", method="get", intro="用户保证金变动记录")
 */
class UserDeposit extends BaseCurd
{
    public function __construct()
    {
        $this->model = new UserDepositModel();
        parent::__construct();
    }

    /**
     * @ApiRouter(router="withdraw", method="post", intro="用户提现处理")
     */
    public function withdraw(){
        $depositId = $this->request->input('id');
        if (!$depositId){
            return $this->error('必须传递提现申请记录记录ID');
        }
        $status = $this->request->input('status', 0);
        if (in_array($status, [0, 2]) === false){
            return $this->error('提现状态处理错误');
        }
        $deposit = $this->model->where('deposit_id', $depositId)->where('type', 4)->first();
        if (!$deposit){
            return $this->error('提现申请不存在');
        }
        if ($deposit->status != 0){
            return $this->error('请勿重复处理提现申请');
        }
        $this->model->where('deposit_id', $depositId)->where('type', 4)->update(['status'=>$status]);
        UserService::instance()->getModel()->where('user_id', $deposit->user_id)->decrement('freeze_deposit', $deposit->amount);
        if ($status == 0){
            UserService::instance()->getModel()->where('user_id', $deposit->user_id)->increment('deposit', $deposit->amount);
        }
        return $this->success('提现处理成功');
    }
}