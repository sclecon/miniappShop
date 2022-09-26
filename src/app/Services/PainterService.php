<?php

namespace App\Services;

use App\Model\PainterModel;
use App\Services\BaseSupport\BaseSupportService;

class PainterService extends BaseSupportService
{
    protected $model = PainterModel::class;

    public function detail(int $painterId) : array {
        return $this->getModel()
            ->where('painter_id', $painterId)
            ->select(['painter_id', 'avatar', 'name', 'intro'])
            ->first()
            ->toArray();
    }
}