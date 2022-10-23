<?php

namespace App\Model;

use App\Model\BaseSupport\BaseSupportModel;

class AuctionImageModel extends BaseSupportModel
{
    protected $table = 'auction_images';

    protected $primaryKey = 'images_id';
}