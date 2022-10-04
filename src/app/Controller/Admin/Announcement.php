<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Base\BaseCurd;
use App\Model\BannerModel;

class Announcement extends BaseCurd
{
    public function __construct()
    {
        $this->model = new BannerModel();
        parent::__construct();
    }
}