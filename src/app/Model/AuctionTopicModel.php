<?php

namespace App\Model;

use App\Model\BaseSupport\BaseSupportModel;

class AuctionTopicModel extends BaseSupportModel
{
    protected $table = 'auction_topic';

    protected $primaryKey = 'topic_id';
}