<?php

namespace App\Services;

use App\Model\AuctionImageModel;
use App\Services\BaseSupport\BaseSupportService;
use App\Utils\ArrayExpand;
use App\Utils\Http;

class AuctionImageService extends BaseSupportService
{
    protected $model = AuctionImageModel::class;

    public function getAuctionImagesInAuctionId(array $auctionId) : array {
        $list = $this->getModel()
            ->whereIn('auction_id', $auctionId)
            ->select(['auction_id', 'name', 'url'])
            ->get()
            ->toArray();
        $list = ArrayExpand::columns($list, 'auction_id');
        foreach ($list as $key => $value){
            foreach ($value as $_k => $_v){
                $list[$key][$_k] = $this->format($_v);
            }
        }
        return $list;
    }

    protected function format(array $data) : array {
        $data['url'] = strpos($data['url'], 'http') === 0 ? $data['url'] : Http::instance()->getDomain().$data['url'];
        return $data;
    }
}