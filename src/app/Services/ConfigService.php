<?php

namespace App\Services;

use App\Model\ConfigModel;
use App\Services\BaseSupport\BaseSupportService;

class ConfigService extends BaseSupportService
{
    protected $model = ConfigModel::class;

    public function getNotice() : string {
        $notice = $this->getModel()
            ->where('uuid', 'notice')
            ->value('value');
        return $notice ? htmlspecialchars_decode($notice) : '暂未配置';
    }
}