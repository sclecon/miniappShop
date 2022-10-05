<?php

namespace App\Services;

use App\Model\PainterModel;
use App\Services\BaseSupport\BaseSupportService;
use App\Utils\ArrayExpand;

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

    public function getPainterNamesInId(array $ids) : array {
        $list = $this->getModel()
            ->whereIn('painter_id', $ids)
            ->select(['painter_id', 'name'])
            ->get()
            ->toArray();
        return ArrayExpand::columnKey($list, 'painter_id', 'name');
    }
}