<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/10/14 16:40
 */

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\BaseSupport\BaseSupportController;
use App\Services\ShopService;

/**
 * @ApiRouter(router="port/shop", method="get", intro="商品模块")
 */
class Shop extends BaseSupportController
{
    /**
     * @ApiRouter(router="all", method="get", intro="推荐商品")
     * @Validator(attribute="category_id", required=true, rule="integer", intro="分类ID")
     */
    public function recommend(){
        $categoryId = (int) $this->request->input('category_id');
        return $this->success('获取推荐商品成功', ShopService::instance()->getRecommend($categoryId));
    }


    /**
     * @ApiRouter(router="detail", method="get", intro="获取商品详情")
     * @Validator(attribute="shop_id", required=true, rule="integer", intro="商品ID")
     */
    public function detail(){
        $shopId = (int) $this->request->input('shop_id');
        return $this->success('获取推荐商品成功', ShopService::instance()->detail($shopId));
    }


    /**
     * @ApiRouter(router="list", method="get", intro="获取商品列表")
     * @Validator(attribute="category_id", required=true, rule="integer", intro="分类ID")
     * @Validator(attribute="search", required=false, rule="string", intro="搜索关键词")
     * @Validator(attribute="recommend", required=false, rule="integer", intro="是否为推荐")
     * @Validator(attribute="order_field", required=false, rule="string", intro="排序字段")
     * @Validator(attribute="order_desc", required=false, rule="string", intro="排序方式")
     * @Validator(attribute="page", required=false, rule="integer", intro="分页")
     * @Validator(attribute="number", required=false, rule="integer", intro="每页数量")
     */
    public function list(){
        $categoryId = (int) $this->request->input('category_id');
        $search = (string) $this->request->input('search');
        $recommend = (bool) $this->request->input('recommend');
        $orderField = (string) $this->request->input('order_field', 'shop_id');
        $orderDesc = (string) in_array($this->request->input('order_desc'), ['desc', 'asc']) ? $this->request->input('order_desc') : 'desc';
        $page = (int) $this->request->input('page', 1);
        $number = (int) $this->request->input('number', 20);
        return $this->success('获取推荐商品成功', ShopService::instance()->list($categoryId, $search, $recommend, $orderField, $orderDesc, $page, $number));
    }
}