<?php

namespace App\Model;

use App\Model\BaseSupport\BaseSupportModel;

class BannerModel extends BaseSupportModel
{
    protected $table = 'banner';

    protected $primaryKey = 'banner_id';
}