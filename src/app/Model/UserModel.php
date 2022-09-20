<?php

namespace App\Model;

use App\Model\BaseSupport\BaseSupportModel;

class UserModel extends BaseSupportModel
{
    protected $table = 'user';

    protected $primaryKey = 'user_id';
}