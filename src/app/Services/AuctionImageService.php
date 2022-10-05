<?php

namespace App\Services;

use App\Model\AuctionImageModel;
use App\Services\BaseSupport\BaseSupportService;
use App\Utils\ArrayExpand;

class AuctionImageService extends BaseSupportService
{
    protected $model = AuctionImageModel::class;

    public function getAuctionImagesInAuctionId(array $auctionId) : array {
        $list = $this->getModel()
            ->whereIn('auction_id', $auctionId)
            ->select(['auction_id', 'name', 'url'])
            ->get()
            ->toArray();
        return ArrayExpand::columns($list, 'auction_id');
    }
}