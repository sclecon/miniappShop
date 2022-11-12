<?php

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Controller\BaseSupport\BaseSupportController;
use App\Services\ConfigService;
use App\Middleware\User\AuthenticationMiddleware;

/**
 * @ApiRouter(router="port/server", method="get", intro="系统相关", middleware={AuthenticationMiddleware::class})
 */
class Server extends BaseSupportController
{
    /**
     * @ApiRouter(router="notice", method="get", intro="获取系统须知")
     */
    public function notice(){
        return $this->success('获取须知成功', [
            'message'   =>  ConfigService::instance()->getNotice()
        ]);
    }

    /**
     * @ApiRouter(router="tel", method="get", intro="获取客服联系电话")
     */
    public function tel(){
        return $this->success('获取客服联系电话成功', [
            'message'   =>  ConfigService::instance()->getSystemTel()
        ]);
    }
}