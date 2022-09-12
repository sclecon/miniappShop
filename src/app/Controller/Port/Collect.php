<?php

namespace App\Controller\Port;

use App\Controller\BaseSupport\BaseSupportController;
use App\Annotation\ApiRouter;
use App\Services\CollectMenuService;
use App\Annotation\Validator;
use App\Services\CollectService;
use App\Services\ItemService;
use App\Middleware\User\AuthenticationMiddleware;

/**
 * @ApiRouter(router="port/collect", method="get", intro="模型收藏管理", middleware={AuthenticationMiddleware::class})
 */
class Collect extends BaseSupportController
{
    /**
     * @ApiRouter(router="menu/list", method="get", intro="获取所有收藏目录")
     */
    public function menulist(){
        $user_id = (int) $this->request->getAttribute('user_id');
        list($useCache, $list) = CollectMenuService::instance()->all($user_id);
        return $this->success('获取目录成功',[
            'cache'     =>  $useCache,
            'list'      =>  $list,
        ]);
    }

    /**
     * @ApiRouter(router="add", method="put", intro="添加模型收藏")
     * @Validator(attribute="item_id", required=true, rule="integer", intro="模型ID")
     * @Validator(attribute="menu_name", required=true, rule="string", intro="分组名称")
     */
    public function add(){
        $user_id = (int) $this->request->getAttribute('user_id');
        $item = ItemService::instance()->getItemById((int) $this->request->input('item_id'));
        if (!$item){
            return $this->error('模型不存在');
        }
        $menu_name = (string) $this->request->input('menu_name');
        return $this->success('添加收藏成功',[
            'response'  =>  CollectService::instance()->add($user_id, (int) $this->request->input('item_id'), $menu_name),
        ]);
    }

    /**
     * @ApiRouter(router="rm", method="delete", intro="取消模型收藏")
     * @Validator(attribute="item_id", required=true, rule="integer", intro="模型ID")
     */
    public function rm(){
        $user_id = (int) $this->request->getAttribute('user_id');
        $item = ItemService::instance()->getItemById((int) $this->request->input('item_id'));
        if (!$item){
            return $this->error('模型不存在');
        }
        CollectService::instance()->del($user_id, (int) $this->request->input('item_id'));
        return $this->success('取消收藏成功');
    }

    /**
     * @ApiRouter(router="menu/rm", method="delete", intro="删除收藏目录")
     * @Validator(attribute="menu_id", required=true, rule="integer", intro="目录ID")
     * @Validator(attribute="clear", required=false, rule="integer", intro="是否清空目录下收藏数据")
     */
    public function rmMenu(){
        $user_id = (int) $this->request->getAttribute('user_id');
        $menu_id = (int) $this->request->input('menu_id');
        $clear = (bool) $this->request->input('clear', 0);
        CollectMenuService::instance()->rm($user_id, $menu_id, $clear);
        return $this->success('删除收藏分类成功');
    }

    /**
     * @ApiRouter(router="menu/edit", method="post", intro="修改收藏目录")
     * @Validator(attribute="menu_id", required=true, rule="integer", intro="目录ID")
     * @Validator(attribute="name", required=true, rule="string", intro="目录新名称")
     */
    public function editMenu(){
        $user_id = (int) $this->request->getAttribute('user_id');
        $menu_id = (int) $this->request->input('menu_id');
        $menuName = (string) $this->request->input('name');
        CollectMenuService::instance()->reName($user_id, $menu_id, $menuName);
        return $this->success('修改名称成功');
    }
}