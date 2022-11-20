<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Controller;

use App\Annotation\ApiRouter;
use App\Controller\Admin\AuctionJoin;
use App\Controller\BaseSupport\BaseSupportController;
use App\Services\AuctionJoinService;

/**
 * @ApiRouter(router="index", method="get")
 */
class Index extends BaseSupportController
{
    /**
     * @ApiRouter(router="/", method="get", intro="首页")
     */
    public function index()
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();

        return [
            'method' => $method,
            'message' => "Hello {$user}.",
        ];
    }

    /**
     * @ApiRouter(router="/test", method="get", intro="首页")
     */
    public function test(){
        AuctionJoinService::instance()->openJoin();
        return $this->success('test');
    }
}
