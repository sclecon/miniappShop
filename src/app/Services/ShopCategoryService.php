<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/10/13 17:54
 */

namespace App\Services;

use App\Model\ShopCategoryModel;
use App\Services\BaseSupport\BaseSupportService;
use App\Utils\Http;

class ShopCategoryService extends BaseSupportService
{
    protected $model = ShopCategoryModel::class;

    public function all() : array {
        $list = $this->getModel()
            ->orderByDesc('weight')
            ->orderByDesc('category_id')
            ->select(['name', 'intro', 'image', 'category_id'])
            ->get()
            ->toArray();
        foreach ($list as $key => $value){
            $list[$key]['image'] = Http::instance()->image($value['image']);
        }
        return $list;
    }
}