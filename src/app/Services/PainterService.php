<?php

namespace App\Services;

use App\Model\PainterModel;
use App\Services\BaseSupport\BaseSupportService;
use App\Utils\ArrayExpand;
use App\Utils\Http;

class PainterService extends BaseSupportService
{
    protected $model = PainterModel::class;

    public function detail(int $painterId) : array {
        $pointer = $this->getModel()
            ->where('painter_id', $painterId)
            ->select(['painter_id', 'avatar', 'name', 'intro'])
            ->first()
            ->toArray();
        $pointer['avatar'] = strpos($pointer['avatar'], 'http') === 0 ? $pointer['avatar'] : Http::instance()->getDomain().$pointer['avatar'];
        return $pointer;
    }

    public function getPainterNamesInId(array $ids) : array {
        $list = $this->getModel()
            ->whereIn('painter_id', $ids)
            ->select(['painter_id', 'name', 'avatar'])
            ->get()
            ->toArray();
        return ArrayExpand::column($list, 'painter_id');
        // return ArrayExpand::columnKey($list, 'painter_id', 'name');
    }
}