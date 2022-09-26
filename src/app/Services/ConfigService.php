<?php

namespace App\Services;

use App\Model\ConfigModel;
use App\Services\BaseSupport\BaseSupportService;

class ConfigService extends BaseSupportService
{
    protected $model = ConfigModel::class;
}