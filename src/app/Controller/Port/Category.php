<?php

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Controller\BaseSupport\BaseSupportController;
use App\Services\CategoryService;
use App\Middleware\User\AuthenticationMiddleware;

/**
 * @ApiRouter(router="port/category", method="get", intro="模型分类", middleware={AuthenticationMiddleware::class})
 */
class Category extends BaseSupportController
{
    /**
     * @ApiRouter(router="all", method="get", intro="所有分类")
     */
    public function all(){
        list($useCache, $list) = CategoryService::instance()->all();
        return $this->success('获取所有分类成功', [
            'cache'     =>  $useCache,
            'list'      =>  $list,
        ]);
    }
}