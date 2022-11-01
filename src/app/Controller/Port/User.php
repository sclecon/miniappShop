<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/11/1 17:12
 */

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\BaseSupport\BaseSupportController;
use App\Services\AuctionJoinService;
use App\Services\UserDepositService;
use App\Services\UserService;

/**
 * @ApiRouter(router="port/user", method="get", intro="用户相关")
 */
class User extends BaseSupportController
{

    /**
     * @ApiRouter(router="deposit", method="get", intro="获取用户保证金")
     */
    public function deposit(){
        $userId = $this->getAuthUserId();
        return $this->success('获取保证金成功', UserService::instance()->getUserDepositInfo($userId));
    }

    /**
     * @ApiRouter(router="deposit", method="get", intro="获取用户保证金")
     * @Validator(attribute="type", required=false, rule="integer", intro="记录类型")
     * @Validator(attribute="page", required=false, rule="integer", intro="分页")
     * @Validator(attribute="number", required=false, rule="integer", intro="每页数量")
     */
    public function depositlog(){
        $userId = $this->getAuthUserId();
        $page = (int) $this->request->input('page', 1);
        $number = (int) $this->request->input('number', 20);
        $type = (int) $this->request->input('type', 0);
        return $this->success('获取记录成功', [
            'list'  =>  UserDepositService::instance()->list($userId, $type, $page, $number)
        ]);
    }

    /**
     * @ApiRouter(router="auction/join/list", method="get", intro="我的竞拍记录")
     * @Validator(attribute="status", required=false, rule="integer", intro="竞拍结果状态")
     * @Validator(attribute="page", required=false, rule="integer", intro="分页")
     * @Validator(attribute="number", required=false, rule="integer", intro="每页数量")
     */
    public function list(){
        $status = (int) $this->request->input('status', 999);
        $page = (int) $this->request->input('page', 1);
        $number = (int) $this->request->input('number', 20);
        return $this->success('获取我的竞拍记录成功', [
            'list'   =>   AuctionJoinService::instance()->userJoinList($status, $page, $number)
        ]);
    }
}