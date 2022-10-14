<?php

namespace App\Services;

use App\Model\BannerModel;
use App\Services\BaseSupport\BaseSupportService;
use App\Utils\Http;

class BannerService extends BaseSupportService
{
    protected $model = BannerModel::class;

    public function all() : array {
        $list = $this->getModel()
            ->select(['url'])
            ->orderByDesc('weight')
            ->pluck('url')
            ->toArray();
        foreach ($list as $key => $value){
            $list[$key] = strpos($value, 'http') === 0 ? $value : Http::instance()->getDomain().$value;
        }
        return $list;
    }
}