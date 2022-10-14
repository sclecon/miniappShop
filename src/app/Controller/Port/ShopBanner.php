<?php

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Controller\BaseSupport\BaseSupportController;
use App\Services\ShopBannerService;

/**
 * @ApiRouter(router="port/shop/banner", method="get", intro="市场Banner")
 */
class ShopBanner extends BaseSupportController
{
    /**
     * @ApiRouter(router="list", method="get", intro="Banner列表")
     */
    public function list(){
        return $this->success('获取Banner列表成功', [
            'list'  =>  ShopBannerService::instance()->all(),
        ]);
    }
}