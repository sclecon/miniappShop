<?php

namespace App\Model;

use App\Model\BaseSupport\BaseSupportModel;

class AdminModel extends BaseSupportModel
{
    protected $table = 'admin';

    protected $primaryKey = 'admin_id';
}