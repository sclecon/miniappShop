<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\AuctionModel;
use App\Services\AuctionImageService;
use App\Services\AuctionService;
use App\Services\PainterService;
use App\Utils\ArrayExpand;
use App\Middleware\Admin\AuthenticationMiddleware;

/**
 * @ApiRouter(router="admin/auction", method="get", intro="拍品管理", middleware={AuthenticationMiddleware::class})
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
            $painterId = array_unique(array_values(ArrayExpand::columnKey($list, 'auction_id', 'painter_id')));
            $painterNames = PainterService::instance()->getPainterNamesInId($painterId);
            $painterId = array_keys(ArrayExpand::columns($list, 'auction_id'));
            $images = AuctionImageService::instance()->getAuctionImagesInAuctionId($painterId);
            foreach ($list as $key => $value){
                $list[$key] = AuctionService::instance()->format($value, $painterNames, $images, []);
            }
        }
        return $this->success('获取数据列表成功', [
            'count' =>  $count,
            'list'  =>  $list
        ]);
    }
}