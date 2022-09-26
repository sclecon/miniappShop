<?php

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Controller\BaseSupport\BaseSupportController;
use App\Services\BannerService;

/**
 * @ApiRouter(router="port/banner", method="get", intro="首页轮播图")
 */
class Banner extends BaseSupportController
{
    /**
     * @ApiRouter(router="list", method="get", intro="获取首页轮播图")
     */
    public function list(){
        return $this->success('获取首页轮播图成功', [
            'list'  =>  BannerService::instance()->all()
        ]);
    }
}