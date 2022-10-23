<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/10/13 17:54
 */

namespace App\Services;

use App\Model\ShopImageModel;
use App\Services\BaseSupport\BaseSupportService;
use App\Utils\ArrayExpand;
use App\Utils\Http;

class ShopImageService extends BaseSupportService
{
    protected $model = ShopImageModel::class;

    public function getShopImageInShopIds(array $shopIds) : array {
        $list = $this->getModel()
            ->whereIn('shop_id', $shopIds)
            ->select(['shop_id', 'url', 'image_id'])
            ->orderByDesc('weight')
            ->orderByDesc('image_id')
            ->get()
            ->toArray();
        $list = ArrayExpand::columns($list, 'shop_id', 'image_id');
        foreach ($list as $shopId => $value){
            $images = [];
            foreach ($value as $image){
                $images[] = Http::instance()->image($image['url']);
            }
            $list[$shopId] = $images;
        }
        return $list;
    }
}