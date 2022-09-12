<?php
/**
 * project name Sumod
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/8/18 15:54
 */

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\BaseSupport\BaseSupportController;
use App\Services\ItemService;
use App\Middleware\User\AuthenticationMiddleware;

/**
 * @ApiRouter(router="port/item", method="get", intro="首页", middleware={AuthenticationMiddleware::class})
 */
class Item extends BaseSupportController
{
    /**
     * @ApiRouter(router="list", method="get", intro="获取模型列表")
     * @Validator(attribute="number" , rule="integer", intro="每页条数")
     * @Validator(attribute="page" , rule="integer", intro="当前第几页")
     * @Validator(attribute="order" , rule="string", intro="排序字段")
     * @Validator(attribute="search" , rule="string", intro="搜索关键词")
     * @Validator(attribute="history" , rule="integer", intro="查看历史")
     * @Validator(attribute="collect_menu_id" , rule="integer", intro="收藏目录ID")
     */
    public function list(){
        $number = (int) $this->request->input('number', 20);
        $page = (int) $this->request->input('page', 1);
        $order = $this->request->input('order', 'create_time');
        $desc = $this->request->input('desc', true) ? 'desc' : 'asc';
        $search = $this->request->input('search', '');
        $history = (int) $this->request->input('history', 0);
        $userId = (int) $this->request->getAttribute('user_id');
        $collectMenuId = (int) $this->request->input('collect_menu_id', 0);
        list($list, $cache) = ItemService::instance()->list($number, $page, $order, $desc, $search, $history, $userId, $collectMenuId);
        return $this->success('获取模型列表成功', [
            'cache'     =>  $cache,
            'list'      =>  $list,
        ]);
    }
}