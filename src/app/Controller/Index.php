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
use App\Utils\AliyunSms;

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
        return $this->response->redirect('/static/index.html');
    }

    /**
     * @ApiRouter(router="/test", method="get", intro="测试自动开奖竞拍")
     */
    public function test(){
        AuctionJoinService::instance()->openJoin();
        return $this->success('test');
    }

    /**
     * @ApiRouter(router="/send/code", method="get", intro="测试发送短信")
     */
    public function sendCode(){
        $code = rand(100000, 999999);
        $phone = "18583761997";
        $response = AliyunSms::instance()->sendCode($phone, $code);
        return $this->success('发送短信成功', [
            'phone'     =>  $phone,
            'code'      =>  $code,
            'response'  =>  $response,
        ]);
    }
}
