<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/10/13 17:54
 */

namespace App\Services;

use App\Exception\Service\ShopServiceException;
use App\Model\ShopModel;
use App\Services\BaseSupport\BaseSupportService;
use App\Utils\ArrayExpand;

class ShopService extends BaseSupportService
{
    protected $model = ShopModel::class;

    public function getRecommend(int $categoryId) : array {
        $detail = $this->getModel()
            ->where('category_id', $categoryId)
            ->where('recommend', 1)
            ->orderByDesc('weight')
            ->orderByDesc('shop_id')
            ->first()
            ->toArray();
        if (!$detail){
            throw new ShopServiceException('暂无推荐商品', 4004);
        }
        $shopImages = ShopImageService::instance()->getShopImageInShopIds([$detail['shop_id']]);
        return $this->format($detail, $shopImages);
    }

    public function detail(int $shopId) : array {
        $detail = $this->getModel()
            ->where('shop_id', $shopId)
            ->first()
            ->toArray();
        if (!$detail){
            throw new ShopServiceException('商品不存在');
        }
        $shopImages = ShopImageService::instance()->getShopImageInShopIds([$detail['shop_id']]);
        return $this->format($detail, $shopImages);
    }

    public function list(int $categoryId, string $search, bool $isRecommend, string $orderField, string $orderDesc, int $page, int $number){
        $model = $this->getModel();
        if ($categoryId){
            $model = $model->where('category_id', $categoryId);
        }
        if ($search){
            $model = $model->where('name', 'like', '%'.$categoryId.'%');
            $model = $model->where('intro', 'like', '%'.$categoryId.'%');
        }
        if ($isRecommend){
            $model = $model->where('recommend', 1);
        }
        $model = $model->orderBy($orderField, $orderDesc);
        $model = $model->select(['shop_id', 'category_id', 'name', 'intro', 'price', 'options']);
        $model = $model->forPage($page, $number);
        $list = $model->get()->toArray();
        $shopImages = ArrayExpand::getKeys($list, 'shop_id') ? ShopImageService::instance()->getShopImageInShopIds(ArrayExpand::getKeys($list, 'shop_id')) : [];
        foreach ($list as $key => $value){
            $list[$key] = $this->format($value, $shopImages);
        }
        return $list;
    }

    protected function format(array $shop, array $shopImages) : array {
        $shop['options'] = json_decode($shop['options'], true) ?: [];
        $shop['message'] = htmlspecialchars_decode($shop['message']);
        if (isset($shop['created_time'])) $shop['created_time_str'] = date('Y-m-d H:i:s', $shop['created_time']);
        $shop['shop_image'] = isset($shopImages[$shop['shop_id']]) ? $shopImages[$shop['shop_id']] : [];
        return $shop;
    }
}