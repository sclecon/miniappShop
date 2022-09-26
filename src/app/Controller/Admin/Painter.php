<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\PainterModel;

/**
 * @ApiRouter(router="admin/painter", method="get", intro="画家管理")
 */
class Painter extends BaseCurd
{
    public function __construct()
    {
        $this->model = new PainterModel();
        parent::__construct();
    }
}