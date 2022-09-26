<?php

namespace App\Model;

use App\Model\BaseSupport\BaseSupportModel;

class ConfigModel extends BaseSupportModel
{
    protected $table = 'config';

    protected $primaryKey = 'config_id';
}