<?php

declare(strict_types=1);
/**
 * project name Sumod
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/8/17 11:46
 */

namespace App\Controller\BaseSupport;

use App\Traits\Controller\Response;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Container\ContainerInterface;
use Hyperf\Di\Annotation\Inject;

abstract class BaseSupportController
{
    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    /**
     * @Inject
     * @var ResponseInterface
     */
    protected $response;

    use Response;

    protected function getAuthUserId() : int {
        $user = $this->request->getAttribute('user');
        $userId = $user ? $user['user_id'] : 1;
        return (int) $userId;
    }
}