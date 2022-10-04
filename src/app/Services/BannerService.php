<?php

namespace App\Services;

use App\Model\BannerModel;
use App\Services\BaseSupport\BaseSupportService;

class BannerService extends BaseSupportService
{
    protected $model = BannerModel::class;

    public function all() : array {
        return $this->getModel()
            ->select(['url'])
            ->orderByDesc('weight')
            ->pluck('url')
            ->toArray();
    }
}