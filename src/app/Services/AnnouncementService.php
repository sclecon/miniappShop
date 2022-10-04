<?php

namespace App\Services;

use App\Model\AnnouncementModel;
use App\Services\BaseSupport\BaseSupportService;

class AnnouncementService extends BaseSupportService
{
    protected $model = AnnouncementModel::class;

    public function newList(int $number) : array {
        $list = $this->getModel()
            ->select(['announcement_id', 'title', 'message', 'created_time'])
            ->forPage(1, $number)
            ->get()
            ->toArray();
        foreach ($list as $key => $value){
            $list[$key]['created_time'] = date('Y-m-d H:i', $value['created_time']);
        }
        return $list;
    }
}