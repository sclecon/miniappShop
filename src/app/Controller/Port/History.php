<?php

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\BaseSupport\BaseSupportController;
use App\Middleware\User\AuthenticationMiddleware;
use App\Services\HistoryService;

/**
 * @ApiRouter(router="port/history", method="get", intro="模型收藏", middleware={AuthenticationMiddleware::class})
 */
class History extends BaseSupportController
{
    /**
     * @ApiRouter(router="add", method="put", intro="添加历史")
     * @Validator(attribute="item_id", required=true, rule="integer", intro="模型ID")
     * @throws \App\Exception\Service\HistoryException
     */
    public function add(){
        $userId = (int) $this->request->getAttribute('user_id');
        $itemId = (int) $this->request->input('item_id');
        HistoryService::instance()->addHistory($userId, $itemId);
        return $this->success('添加历史记录成功');
    }

    /**
     * @ApiRouter(router="del", method="delete", intro="删除历史")
     * @Validator(attribute="item_id", required=true, rule="integer", intro="模型ID")
     * @throws \App\Exception\Service\HistoryException
     */
    public function del(){
        $userId = (int) $this->request->getAttribute('user_id');
        $itemId = (int) $this->request->input('item_id');
        HistoryService::instance()->deleteHistory($userId, $itemId);
        return $this->success('删除历史成功');
    }

    /**
     * @ApiRouter(router="delAll", method="delete", intro="删除所有历史")
     */
    public function delAll()
    {
        $userId = (int) $this->request->getAttribute('user_id');
        HistoryService::instance()->deleteAllHistory($userId);
        return $this->success('删除所有历史成功');
    }

    /**
     * @ApiRouter(router="list", method="get", intro="获取历史数据列表")
     * @Validator(attribute="number", required=false, rule="integer", intro="获取数量")
     */
    public function list(){
        $number = (int) $this->request->input('number', 1000);
        $userId = (int) $this->request->getAttribute('user_id');
        return $this->success('获取所有历史成功', [
            'list'  =>  HistoryService::instance()->list($number, $userId)
        ]);
    }
}