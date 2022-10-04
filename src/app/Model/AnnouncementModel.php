<?php

namespace App\Model;

use App\Model\BaseSupport\BaseSupportModel;

class AnnouncementModel extends BaseSupportModel
{
    protected $table = 'announcement';

    protected $primaryKey = 'announcement_id';
}