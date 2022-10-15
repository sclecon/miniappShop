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
            ->select(['shop_id', 'url'])
            ->orderByDesc('weight')
            ->orderByDesc('image_id')
            ->get()
            ->toArray();
        $list = ArrayExpand::columnKey($list, 'shop_id', 'url');
        foreach ($list as $key => $value){
            $list[$key] = Http::instance()->image($value);
        }
        return $list;
    }
}