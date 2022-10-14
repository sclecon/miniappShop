<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/10/14 16:35
 */

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Controller\BaseSupport\BaseSupportController;
use App\Services\ShopCategoryService;

/**
 * @ApiRouter(router="port/shop/category", method="get", intro="市场模块分类")
 */
class ShopCategory extends BaseSupportController
{
    /**
     * @ApiRouter(router="all", method="get", intro="所有分类")
     */
    public function all(){
        return $this->success('获取所有分类', [
            'list'  =>  ShopCategoryService::instance()->all(),
        ]);
    }
}