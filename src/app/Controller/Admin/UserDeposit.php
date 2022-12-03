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
use App\Utils\ArrayExpand;

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
        if ($deposit->tx_status != 1){
            return $this->error('请勿重复处理提现申请');
        }
        $this->model->where('deposit_id', $depositId)->where('type', 4)->update(['tx_status'=>$status]);
        UserService::instance()->getModel()->where('user_id', $deposit->user_id)->decrement('freeze_deposit', $deposit->amount);
        if ($status == 0){
            UserService::instance()->getModel()->where('user_id', $deposit->user_id)->increment('deposit', $deposit->amount);
        }
        return $this->success('提现处理成功');
    }

    /**
     * @ApiRouter(router="list", intro="列表", method="GET")
     * @Validator(attribute="page", rule="integer|min:1", required=false)
     * @Validator(attribute="number", rule="integer|min:10|max:100", required=false)
     */
    public function list(){
        $page = (int) $this->request->input('page', 1);
        $number = (int) $this->request->input('number', 10);
        $condition = $this->search->getCondition();
        $model = $this->model->where($condition);
        $count = $model->count();
        $list = [];
        if ($count){
            $list = $model->forPage($page, $number)
                ->orderByDesc('created_time')
                ->select()
                ->get()
                ->toArray();
            $userId = ArrayExpand::getKeys($list, 'user_id');
            $users = $userId ? UserService::instance()->getUserInfoInUserId($userId) : [];
            foreach ($list as $key => $item){
                $list[$key]['user'] = isset($users[$item['user_id']]) ? $users[$item['user_id']] : [];
                $list[$key]['params'] = json_decode($item['params']);
            }
        }
        return $this->success('获取数据列表成功', [
            'count' =>  $count,
            'list'  =>  $list
        ]);
    }

    /**
     * @ApiRouter(router="find", intro="获取详情", method="GET")
     * @Validator(attribute="id", rule="integer", required=true)
     */
    public function find(){
        $primaryKey = $this->request->input('id', 0);
        $data = $this->model
            ->where($this->model->getPrimaryKey(), $primaryKey)
            ->first();
        if ($data){
            $users = UserService::instance()->getUserInfoInUserId([$data->user_id]);
            $data->user = isset($users[$data->user_id]) ? $users[$data->user_id] : [];
            $data->params = json_decode($data->params);
        }
        return $data ?  $this->success('获取数据详情成功', $data->toArray()) : $this->error('获取数据详情失败');
    }
}