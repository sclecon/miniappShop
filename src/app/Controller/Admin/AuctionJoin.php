<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\AuctionJoinModel;
use App\Services\AuctionService;
use App\Services\UserService;
use App\Utils\ArrayExpand;

/**
 * @ApiRouter(router="admin/auction/join", method="get", intro="竞拍管理")
 */
class AuctionJoin extends BaseCurd
{
    public function __construct()
    {
        $this->model = new AuctionJoinModel();
        parent::__construct();
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
            $users = UserService::instance()->getUserInfoInUserId(ArrayExpand::getKeys($list, 'user_id'));
            $auctions = AuctionService::instance()->getAuctionListInAuctionIds(ArrayExpand::getKeys($list, 'auction_id'));
            foreach ($list as $key => $value){
                $list[$key]['user'] = isset($users[$value['user_id']]) ? $users[$value['user_id']] : [];
                $list[$key]['auction'] = isset($auctions[$value['auction_id']]) ? $auctions[$value['auction_id']] : [];
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
        return $data ?  $this->success('获取数据详情成功', $data->toArray()) : $this->error('获取数据详情失败');
    }
}