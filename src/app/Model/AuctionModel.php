<?php

namespace App\Model;

use App\Model\BaseSupport\BaseSupportModel;

class AuctionModel extends BaseSupportModel
{
    protected $table = 'auction';

    protected $primaryKey = 'auction_id';
}