<?php

namespace App\Services;

use App\Model\ShopBannerModel;
use App\Services\BaseSupport\BaseSupportService;
use App\Utils\Http;

class ShopBannerService extends BaseSupportService
{
    protected $model = ShopBannerModel::class;

    public function all() : array {
        $urls = $this->getModel()
            ->orderByDesc('weight')
            ->orderByDesc('banner_id')
            ->pluck('url')
            ->toArray();
        foreach ($urls as $key => $url){
            $urls[$key] = Http::instance()->image($url);
        }
        return $urls;
    }
}