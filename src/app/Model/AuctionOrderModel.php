<?php

namespace App\Model;

use App\Model\BaseSupport\BaseSupportModel;

class AuctionOrderModel extends BaseSupportModel
{
    protected $table = 'auction_order';

    protected $primaryKey = 'order_id';
}