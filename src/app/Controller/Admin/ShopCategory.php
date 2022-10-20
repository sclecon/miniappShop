<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\Admin\Base\UploadImage;
use App\Model\ShopCategoryModel;

/**
 * @ApiRouter(router="admin/shop/category", method="get", intro="商品分类")
 */
class ShopCategory extends UploadImage
{

    protected $moreFormData = true;
    protected $imageModule = 'shop/category';


    public function __construct()
    {
        $this->model = new ShopCategoryModel();
        parent::__construct();
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
        if($data){
            $data->options = json_decode($data->options, true) ?: [];
        }
        return $data ?  $this->success('获取数据详情成功', $data->toArray()) : $this->error('获取数据详情失败');
    }
}