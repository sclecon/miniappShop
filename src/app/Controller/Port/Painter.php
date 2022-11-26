<?php

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\BaseSupport\BaseSupportController;
use App\Services\PainterService;

/**
 * @ApiRouter(router="port/painter", method="get", intro="画家相关")
 */
class Painter extends BaseSupportController
{
    /**
     * @ApiRouter(router="detele", method="get", intro="获取画家详情")
     * @Validator(attribute="painter_id", required=true, rule="integer", intro="画家ID")
     */
    public function delete(){
        $painterId = (int) $this->request->input('painter_id', 0);
        $painter = PainterService::instance()->detail($painterId);
        return $painter ? $this->success('获取画家详情成功', $painter) : $this->error('画家不存在');
    }
}