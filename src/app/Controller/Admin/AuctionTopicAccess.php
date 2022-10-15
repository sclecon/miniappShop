<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\AuctionTopicAccessModel;
use App\Services\AuctionService;
use App\Utils\ArrayExpand;

/**
 * @ApiRouter(router="admin/auction/topic/access", method="get", intro="拍场内拍品管理")
 */
class AuctionTopicAccess extends BaseCurd
{

    public function __construct()
    {
        $this->model = new AuctionTopicAccessModel();
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
            $auctionId = ArrayExpand::getKeys($list, 'auction_id');
            $auctions = $auctionId ? AuctionService::instance()->getAuctionListInAuctionIds($auctionId) : [];
            foreach ($list as $key => $value){
                $list[$key]['auction'] = isset($auctions[$value['auction_id']]) ? $auctions[$value['auction_id']] : [];
            }
        }
        return $this->success('获取数据列表成功', [
            'count' =>  $count,
            'list'  =>  $list
        ]);
    }
}