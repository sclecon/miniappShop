<?php

namespace App\Services;

use App\Exception\Service\AuctionServiceException;
use App\Model\AuctionModel;
use App\Model\AuctionTopicAccessModel;
use App\Services\BaseSupport\BaseSupportService;
use App\Utils\ArrayExpand;
use App\Utils\Http;

class AuctionService extends BaseSupportService
{
    protected $model = AuctionModel::class;

    public function getBoutique(int $page, int $number, int $userId, int $painterId) : array {
        $list = $this->getModel()
            ->whereIn('status', [0, 1])
            ->where('boutique', '>', 0);
        if ($painterId){
            $list = $list->where('painter_id', $painterId);
        }
        $list = $list->forPage($page, $number)
            ->select(['auction_id', 'painter_id', 'name', 'intro', 'start_price', 'start_time', 'end_time', 'status', 'buy_now_price'])
            ->orderByDesc('auction_id')
            ->get()
            ->toArray();
        $painterId = array_unique(array_values(ArrayExpand::columnKey($list, 'auction_id', 'painter_id')));
        $painterNames = PainterService::instance()->getPainterNamesInId($painterId);
        $painterId = array_keys(ArrayExpand::columns($list, 'auction_id'));
        $images = AuctionImageService::instance()->getAuctionImagesInAuctionId($painterId);
        $likes = AuctionLikeService::instance()->has($userId, $painterId);
        foreach ($list as $key => $value){
            $list[$key] = $this->format($value, $painterNames, $images, $likes);
        }
        return $list;
    }

    public function list(int $page, int $number, int $status, int $topicId, int $gallery, string $orderBy, int $userId, int $painterId) : array {
        $model = $this->getModel()
            ->forPage($page, $number)
            ->select(['auction_id', 'painter_id', 'name', 'intro', 'start_price', 'start_time', 'end_time', 'status', 'buy_now_price'])
            ->select([
                $this->getModel()->getTableKey('auction_id'),
                $this->getModel()->getTableKey('painter_id'),
                $this->getModel()->getTableKey('name'),
                $this->getModel()->getTableKey('intro'),
                $this->getModel()->getTableKey('start_price'),
                $this->getModel()->getTableKey('start_time'),
                $this->getModel()->getTableKey('end_time'),
                $this->getModel()->getTableKey('status'),
                $this->getModel()->getTableKey('buy_now_price')
            ])
            ->orderByDesc($this->getModel()->getTableKey($orderBy));
        if (in_array($status, [0, 1, 2, 3])){
            $model = $model->where($this->getModel()->getTableKey('status'), $status);
        }
        if ($topicId > 0){
            $access = AuctionTopicAccessService::instance()->getModel();
            $model = $model->join($access->getTable(), $this->getModel()->getTableKey('auction_id'), '=', $access->getTableKey('auction_id'));
            $model = $model->where($access->getTableKey('topic_id'), $topicId);
        }
        if ($gallery > 0){
            $model = $model->where($this->getModel()->getTableKey('gallery'), '>', 0);
        }
        if ($painterId){
            $model = $model->where($this->getModel()->getTableKey('painter_id'), $painterId);
        }
        $list = $model->get()->toArray();
        $painterId = array_unique(array_values(ArrayExpand::columnKey($list, 'auction_id', 'painter_id')));
        $painterNames = PainterService::instance()->getPainterNamesInId($painterId);
        $painterId = array_keys(ArrayExpand::columns($list, 'auction_id'));
        $images = AuctionImageService::instance()->getAuctionImagesInAuctionId($painterId);
        $likes = AuctionLikeService::instance()->has($userId, $painterId);
        foreach ($list as $key => $value){
            $list[$key] = $this->format($value, $painterNames, $images, $likes);
        }
        return $list;
    }

    public function getAuctionListInAuctionIds(array $auctionIds){
        $list = $this->getModel()
            ->whereIn('auction_id', $auctionIds)
            ->select(['auction_id', 'painter_id', 'name', 'intro', 'start_price', 'start_time', 'end_time', 'status', 'buy_now_price'])
            ->get();
        $list = $list ? $list->toArray() : [];
        $painterId = array_unique(array_values(ArrayExpand::columnKey($list, 'auction_id', 'painter_id')));
        $painterNames = PainterService::instance()->getPainterNamesInId($painterId);
        $painterId = array_keys(ArrayExpand::columns($list, 'auction_id'));
        $images = AuctionImageService::instance()->getAuctionImagesInAuctionId($painterId);
        foreach ($list as $key => $value){
            $list[$key] = $this->format($value, $painterNames, $images, []);
        }
        return ArrayExpand::column($list, 'auction_id');
    }

    public function detail(int $auctionId, int $userId) : array {
        $detail = $this->getModel()
            ->where('auction_id', $auctionId)
            ->first();
        $detail = $detail ? $detail->toArray() : [];
        if (!$detail){
            throw new AuctionServiceException('拍品不存在', 404);
        }
        $painterNames = PainterService::instance()->getPainterNamesInId([$detail['painter_id']]);
        $images = AuctionImageService::instance()->getAuctionImagesInAuctionId([$auctionId]);
        $likes = AuctionLikeService::instance()->has($userId, [$auctionId]);
        return $this->format($detail, $painterNames, $images, $likes);
    }

    public function getStatusStr($s) : string {
        $status = [0=>'等待拍卖', 1=>'拍卖中', 2=>'拍卖成功', 3=>'流拍'];
        return isset($status[$s]) ? $status[$s] : '未知状态';
    }

    public function format(array $item, array $painters, array $images, array $likes) : array {
        $item['start_time_str'] = date('Y-m-d H:i:s', $item['start_time']);
        $item['end_time_str'] = date('Y-m-d H:i:s', $item['end_time']);
        $item['status_str'] = $this->getStatusStr($item['status']);
        $painterNames = ArrayExpand::columnKey($painters, 'painter_id', 'name');
        $painterAvatars = ArrayExpand::columnKey($painters, 'painter_id', 'avatar');
        $item['painter'] = isset($painterNames[$item['painter_id']]) ? $painterNames[$item['painter_id']] : '未知画家';
        $item['painter_avatar'] = isset($painterAvatars[$item['painter_id']]) ? $painterAvatars[$item['painter_id']] : '/painter/202211/25/915adc124906ed303457d281f75ef658.jpeg';
        $item['painter_avatar'] = Http::instance()->image($item['painter_avatar']);
        $item['images'] = isset($images[$item['auction_id']]) ? $images[$item['auction_id']] : [];
        if (isset($item['postage'])){
            $item['postage_str'] = $item['postage'] ? '包邮' : '不包邮';
        }
        if (isset($item['commission'])){
            $item['commission_str'] = $item['postage'].'%';
        }
        if (isset($item['delay'])){
            $item['delay_str'] = $item['delay'].'分钟';
        }
        $item['like'] = isset($likes[$item['auction_id']]) ? $likes[$item['auction_id']] : 0;
        return $item;
    }

    public function getIsCanLotteryAuctions() : array {
        $list = $this->getModel()
            ->where('status', 1)
            ->where('start_time', '<', time())
            ->where('end_time', '<', time())
            ->get();
        $list = $list ? $list->toArray() : [];
        $painterId = array_unique(array_values(ArrayExpand::columnKey($list, 'auction_id', 'painter_id')));
        $painterNames = PainterService::instance()->getPainterNamesInId($painterId);
        $painterId = array_keys(ArrayExpand::columns($list, 'auction_id'));
        // $images = AuctionImageService::instance()->getAuctionImagesInAuctionId($painterId);
        $images = [];
        foreach ($list as $key => $value){
            // $list[$key] = $this->format($value, $painterNames, $images, []);
        }
        return ArrayExpand::column($list, 'auction_id');
    }

    public function successAuction(int $auctionId) : int {
        return $this->getModel()->where('auction_id', $auctionId)->update(['status'=>2]);
    }

    public function unsold(int $auctionId) : int {
        return $this->getModel()->where('auction_id', $auctionId)->update(['status'=>3]);
    }

    public function upgradeThisPrice(int $auctionId, $price) : int {
        return $this->getModel()
            ->where('auction_id', $auctionId)
            ->update(['this_price'=>$price]);
    }
}