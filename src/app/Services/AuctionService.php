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
            ->orderByDesc('auction_id')
            ->get()
            ->toArray();
        $painterId = array_unique(array_values(ArrayExpand::columnKey($list, 'auction_id', 'painter_id')));
        $painterNames = PainterService::instance()->getPainterNamesInId($painterId);
        $painterId = array_keys(ArrayExpand::columns($list, 'auction_id'));
        $images = AuctionImageService::instance()->getAuctionImagesInAuctionId($painterId);
        foreach ($list as $key => $value){
            $list[$key] = $this->format($value, $painterNames, $images);
        }
        return $list;
    }

    public function list(int $page, int $number, int $status) : array {
        $model = $this->getModel()
            ->where('boutique', '>', 0)
            ->forPage($page, $number)
            ->select(['auction_id', 'painter_id', 'name', 'intro', 'start_price', 'start_time', 'end_time', 'status', 'buy_now_price'])
            ->orderByDesc('auction_id');
        if (in_array($status, [0, 1, 2, 3])){
            $model = $model->where('status', $status);
        }
        $list = $model->get()->toArray();
        $painterId = array_unique(array_values(ArrayExpand::columnKey($list, 'auction_id', 'painter_id')));
        $painterNames = PainterService::instance()->getPainterNamesInId($painterId);
        $painterId = array_keys(ArrayExpand::columns($list, 'auction_id'));
        $images = AuctionImageService::instance()->getAuctionImagesInAuctionId($painterId);
        foreach ($list as $key => $value){
            $list[$key] = $this->format($value, $painterNames, $images);
        }
        return $list;
    }

    public function getStatusStr($s) : string {
        $status = [0=>'等待拍卖', 1=>'拍卖中', 2=>'拍卖成功', 3=>'流拍'];
        return isset($status[$s]) ? $status[$s] : '未知状态';
    }

    protected function format(array $item, array $painterNames, array $images) : array {
        $item['start_time_str'] = date('Y-m-d H:i:s', time());
        $item['end_time_str'] = date('Y-m-d H:i:s', time());
        $item['status_str'] = $this->getStatusStr($item['status']);
        $item['painter'] = isset($painterNames[$item['painter_id']]) ? $painterNames[$item['painter_id']] : '未知画家';
        $item['images'] = isset($images[$item['auction_id']]) ? $images[$item['auction_id']] : [];
        return $item;
    }
}