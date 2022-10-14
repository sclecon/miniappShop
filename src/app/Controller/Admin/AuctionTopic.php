<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Controller\Admin\Base\UploadImage;
use App\Model\AuctionTopicModel;

/**
 * @ApiRouter(router="admin/auction/topic", method="get", intro="拍品拍场")
 */
class AuctionTopic extends UploadImage
{
    protected $moreFormData = true;
    protected $imageModule = 'auction/topic';
    protected $imageField = 'image';

    public function __construct()
    {
        $this->model = new AuctionTopicModel();
        parent::__construct();
    }
}