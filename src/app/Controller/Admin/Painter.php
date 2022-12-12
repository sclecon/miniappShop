<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Controller\Admin\Base\UploadImage;
use App\Model\PainterModel;
use App\Middleware\Admin\AuthenticationMiddleware;

/**
 * @ApiRouter(router="admin/painter", method="get", intro="画家管理", middleware={AuthenticationMiddleware::class})
 */
class Painter extends UploadImage
{
    protected $moreFormData = true;
    protected $imageModule = 'painter';
    protected $imageField = 'avatar';

    public function __construct()
    {
        $this->model = new PainterModel();
        parent::__construct();
    }
}