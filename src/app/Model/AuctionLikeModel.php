<?php

namespace App\Model;

use App\Model\BaseSupport\BaseSupportModel;

class AuctionLikeModel extends BaseSupportModel
{
    protected $table = 'auction_like';

    protected $primaryKey = 'like_id';
}