<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\AuctionModel;
use App\Services\PainterService;
use App\Utils\ArrayExpand;

/**
 * @ApiRouter(router="admin/auction", method="get", intro="拍品管理")
 */
class Auction extends BaseCurd
{
    public function __construct()
    {
        $this->model = new AuctionModel();
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
            $inIds = ArrayExpand::getKeys($list, 'painter_id');
            $painters = $inIds ? PainterService::instance()->getPainterNamesInId($inIds) : [];
            foreach ($list as $key => $value){
                $list[$key]['painter'] = isset($painters[$value['painter_id']]) ? $painters[$value['painter_id']] : '未知画家';
            }
        }
        return $this->success('获取数据列表成功', [
            'count' =>  $count,
            'list'  =>  $list
        ]);
    }
}