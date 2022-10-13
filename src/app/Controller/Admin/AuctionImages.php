<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\AuctionImageModel;
use App\Utils\Image;

/**
 * @ApiRouter(router="admin/auction/images", method="get", intro="拍品图片")
 */
class AuctionImages extends BaseCurd
{
    public function __construct()
    {
        $this->model = new AuctionImageModel();
        parent::__construct();
    }

    /**
     * @ApiRouter(router="add", intro="新增拍品图片", method="PUT")
     * @Validator(attribute="image", required=true, rule="file|image")
     */
    public function add(){
        $formData = $this->form->getPostData();
        if (!$formData){
            return $this->error('插入数据失败，未能获取到有效数据。');
        }
        $formData['url'] = Image::instance()->upload($this->request->file('image'), 'banner');
        $insertId = $this->model->add($formData);
        $this->cache->clear(__METHOD__, $formData);
        return !$insertId ? $this->error('新增数据失败') : $this->success('新增数据成功', [
            $this->model->getPrimaryKey()       =>  $insertId,
            'data'                              =>  $formData
        ]);
    }

    /**
     * @ApiRouter(router="list", intro="列表", method="GET")
     * @Validator(attribute="page", rule="integer|min:1", required=false)
     * @Validator(attribute="number", rule="integer|min:10|max:100", required=false)
     */
    public function list(){
        $page = (int) $this->request->input('page', 1);
        $number = (int) $this->request->input('number', 10);
        $condition = $this->search->getCondition();
        $model = $this->model->where($condition);
        $count = $model->count();
        $list = [];
        if ($count){
            $list = $model->forPage($page, $number)
                ->orderByDesc('created_time')
                ->select()
                ->get()
                ->toArray();
            foreach ($list as $key => $value){
                $list[$key]['url'] = strpos($list[$key]['url'], 'http') === 0 ? $list[$key]['url'] : Http::instance()->getDomain().$list[$key]['url'];
            }
        }
        return $this->success('获取数据列表成功', [
            'count' =>  $count,
            'list'  =>  $list
        ]);
    }
}