<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\ShopModel;
use App\Middleware\Admin\AuthenticationMiddleware;

/**
 * @ApiRouter(router="admin/shop", method="get", intro="商品管理", middleware={AuthenticationMiddleware::class})
 */
class Shop extends BaseCurd
{
    public function __construct()
    {
        $this->model = new ShopModel();
        parent::__construct();
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
                $list[$key]['options'] = json_decode($value['options']) ?: [];
                $list[$key]['message'] = htmlspecialchars_decode($value['message']);
            }
        }
        return $this->success('获取数据列表成功', [
            'count' =>  $count,
            'list'  =>  $list
        ]);
    }

    /**
     * @ApiRouter(router="find", intro="获取详情", method="GET")
     * @Validator(attribute="id", rule="integer", required=true)
     */
    public function find(){
        $primaryKey = $this->request->input('id', 0);
        $data = $this->model
            ->where($this->model->getPrimaryKey(), $primaryKey)
            ->first();
        if ($data){
            $data->options = json_decode($data->options) ?: [];
            $data->message = htmlspecialchars_decode($data->message);
        }
        return $data ?  $this->success('获取数据详情成功', $data->toArray()) : $this->error('获取数据详情失败');
    }

    /**
     * @ApiRouter(router="edit", intro="数据修改", method="POST")
     * @Validator(attribute="id", rule="integer", required=true)
     */
    public function edit(){
        $primaryKey = (int) $this->request->input('id');
        $data = $this->model
            ->where($this->model->getPrimaryKey(), $primaryKey)
            ->first();
        if (!$data){
            return $this->error('数据不存在');
        }
        $formData = $this->form->getPostData();
        if ($formData['options'] && is_array($formData['options'])){
            $formData['options'] = json_encode($formData['options']);
        }
        if ($formData['message']){
            $formData['message'] = htmlspecialchars($formData['message']);
        }
        $response = $this->model
            ->where($this->model->getPrimaryKey(), $primaryKey)
            ->update($formData);
        if (!$response){
            return $this->error('修改数据失败');
        }
        $this->cache->clear(__METHOD__, $data->toArray());
        return $this->success('修改数据成功', $formData);
    }

    /**
     * @ApiRouter(router="add", intro="新增数据", method="PUT")
     */
    public function add(){
        $formData = $this->form->getPostData();
        if ($formData['options'] && is_array($formData['options'])){
            $formData['options'] = json_encode($formData['options']);
        }
        if ($formData['message']){
            $formData['message'] = htmlspecialchars($formData['message']);
        }
        if (!$formData){
            return $this->error('插入数据失败，未能获取到有效数据。');
        }
        $insertId = $this->model->add($formData);
        $this->cache->clear(__METHOD__, $formData);
        return !$insertId ? $this->error('新增数据失败') : $this->success('新增数据成功', [
            $this->model->getPrimaryKey()       =>  $insertId,
            'data'                              =>  $formData
        ]);
    }
}