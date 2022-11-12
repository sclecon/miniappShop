<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/11/3 17:26
 */

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Controller\BaseSupport\BaseSupportController;
use App\Middleware\User\AuthenticationMiddleware;

/**
 * @ApiRouter(router="port/pay", method="get", intro="支付相关", middleware={AuthenticationMiddleware::class})
 */
class Pay extends BaseSupportController
{

}