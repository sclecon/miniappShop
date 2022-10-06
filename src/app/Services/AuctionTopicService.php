<?php

namespace App\Services;

use App\Exception\Service\AuctionTopicServiceException;
use App\Model\AuctionTopicModel;
use App\Services\BaseSupport\BaseSupportService;

class AuctionTopicService extends BaseSupportService
{
    protected $model = AuctionTopicModel::class;

    public function getBoutique(int $page, int $number){
        $list = $this->getModel()
            ->whereIn('status', [0, 1])
            ->where('boutique', '>', 0)
            ->forPage($page, $number)
            ->orderByDesc('topic_id')
            ->select(['topic_id', 'name', 'start_time', 'image', 'status', 'end_time'])
            ->get()
            ->toArray();
        foreach ($list as $key => $value){
            $list[$key] = $this->format($value);
        }
        return $list;
    }

    public function list(int $page, int $number, int $status) : array {
        $model = $this->getModel()
            ->forPage($page, $number)
            ->select(['topic_id', 'name', 'start_time', 'image', 'status', 'boutique', 'end_time'])
            ->orderByDesc('topic_id');
        if (in_array($status, [0, 1, 2])){
            $model = $model->where('status', $status);
        }
        $list = $model->get()->toArray();
        foreach ($list as $key => $value){
            $list[$key] = $this->format($value);
        }
        return $list;
    }

    public function detail(int $topicId){
        $detail = $this->getModel()
            ->where('topic_id', $topicId)
            ->first()
            ->toArray();
        if (!$detail){
            throw new AuctionTopicServiceException('拍场不存在', 404);
        }
        return $this->format($detail);
    }

    protected function format(array $value) : array {
        $value['start_time_str'] = date('Y-m-d H:i:s', $value['start_time']);
        $value['end_time_str'] = date('Y-m-d H:i:s', $value['end_time']);
        $value['status_str'] = $this->getStatusStr($value['status']);
        return $value;
    }

    protected function getStatusStr($s) : string {
        $status = [0=>'等待拍卖', 1=>'拍卖中', 2=>'拍卖成功'];
        return isset($status[$s]) ? $status[$s] : '未知状态';
    }
}