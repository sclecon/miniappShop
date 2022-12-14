<?php

namespace App\Services;

use App\Model\AuctionTopicAccessModel;
use App\Services\BaseSupport\BaseSupportService;

class AuctionTopicAccessService extends BaseSupportService
{
    protected $model = AuctionTopicAccessModel::class;

    public function getAuctionCountByTopicId(int $topicId) : int {
        return $this->getModel()->where('topic_id', $topicId)->count();
    }
}