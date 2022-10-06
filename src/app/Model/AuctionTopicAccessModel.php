<?php

namespace App\Model;

use App\Model\BaseSupport\BaseSupportModel;

class AuctionTopicAccessModel extends BaseSupportModel
{
    protected $table = 'auction_topic_access';

    protected $primaryKey = 'access_id';
}