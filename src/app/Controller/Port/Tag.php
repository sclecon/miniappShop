<?php
/**
 * project name Sumod
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/8/29 18:29
 */

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Controller\BaseSupport\BaseSupportController;
use App\Middleware\User\AuthenticationMiddleware;
use App\Services\ItemService;

/**
 * @ApiRouter(router="port/tag", method="get", intro="模型收藏管理", middleware={AuthenticationMiddleware::class})
 */
class Tag extends BaseSupportController
{
    /**
     * @ApiRouter(router="all", method="get", intro="获取所有的标签")
     */
    public function all(){
        list($useCache, $list) = ItemService::instance()->getAllKeywords();
        return $this->success('获取所有标签成功', [
            'cache'     =>      $useCache,
            'list'      =>      $list,
        ]);
    }
}