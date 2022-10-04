<?php

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\BaseSupport\BaseSupportController;
use App\Services\AnnouncementService;

/**
 * @ApiRouter(router="port/announcement", method="get", intro="公告相关")
 */
class Announcement extends BaseSupportController
{
    /**
     * @ApiRouter(router="list", method="get", intro="获取首页公告轮播")
     * @Validator(attribute="number", required=false, rule="integer", intro="获取公告数量")
     */
    public function list(){
        $number = (int) $this->request->input('number', 50);
        return $this->success('获取公告列表成功', [
            'list'  =>  AnnouncementService::instance()->newList($number)
        ]);
    }
}