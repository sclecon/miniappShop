<?php

namespace App\Services;

use App\Model\AuctionModel;
use App\Services\BaseSupport\BaseSupportService;
use App\Utils\ArrayExpand;

class AuctionService extends BaseSupportService
{
    protected $model = AuctionModel::class;

    public function getBoutique(int $page, int $number) : array {
        $list = $this->getModel()
            ->whereIn('status', [0, 1])
            ->where('boutique', '>', 0)
            ->forPage($page, $number)
            ->select(['auction_id', 'painter_id', 'name', 'intro', 'start_price', 'start_time', 'end_time', 'status', 'buy_now_price'])
            ->get()
            ->toArray();
        $painterId = array_unique(array_values(ArrayExpand::columnKey($list, 'auction_id', 'painter_id')));
        $painterNames = PainterService::instance()->getPainterNamesInId($painterId);
        $painterId = array_keys(ArrayExpand::columns($list, 'auction_id'));
        $images = AuctionImageService::instance()->getAuctionImagesInAuctionId($painterId);
        foreach ($list as $key => $value){
            $value['start_time_str'] = date('Y-m-d H:i:s', time());
            $value['end_time_str'] = date('Y-m-d H:i:s', time());
            $value['status_str'] = $this->getStatusStr($value['status']);
            $value['painter'] = isset($painterNames[$value['painter_id']]) ? $painterNames[$value['painter_id']] : '未知画家';
            $value['images'] = isset($images[$value['auction_id']]) ? $images[$value['auction_id']] : [];
            $list[$key] = $value;
        }
        return $list;
    }

    public function getStatusStr($s) : string {
        $status = [0=>'等待拍卖', 1=>'拍卖中', 2=>'拍卖成功', 3=>'流拍'];
        return isset($status[$s]) ? $status[$s] : '未知状态';
    }
}