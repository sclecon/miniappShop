<?php

namespace App\Services;

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
            ->select(['topic_id', 'name', 'start_time', 'image'])
            ->get()
            ->toArray();
        foreach ($list as $key => $value){
            $value['start_time_str'] = date('Y-m-d H:i:s', time());
            $list[$key] = $value;
        }
        return $list;
    }
}