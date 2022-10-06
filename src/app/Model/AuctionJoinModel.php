<?php

namespace App\Model;

use App\Model\BaseSupport\BaseSupportModel;

class AuctionJoinModel extends BaseSupportModel
{
    protected $table = 'auction_join';

    protected $primaryKey = 'join_id';
}