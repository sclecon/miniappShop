<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/10/14 09:45
 */

namespace App\Controller\Admin\Base;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Utils\Http;
use App\Utils\Image;

class UploadImage extends BaseCurd
{

    /**
     * @var string
     */
    protected $imageField = 'url';

    /**
     * @var string
     */
    protected $uploadField = 'image';

    /**
     * @var string
     */
    protected $imageModule = 'default';

    /**
     * @var boolean
     */
    protected $moreFormData = false;

    /**
     * @var string[]
     */
    protected $imageTypes = ['png', 'jpeg'];

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
            $imageField = $this->imageField;
            $data->$imageField = Http::instance()->image($data->$imageField);
        }
        return $data ?  $this->success('获取数据详情成功', $data->toArray()) : $this->error('获取数据详情失败');
    }


    /**
     * @ApiRouter(router="add", intro="新增拍品图片", method="PUT")
     */
    public function add(){
        $formData = $this->form->getPostData();
        if (!$formData && $this->moreFormData){
            return $this->error('插入数据失败，未能获取到有效数据。');
        }
        if (!$file = $this->request->file($this->uploadField)){
            return $this->error('必须上传图片文件，字段为：image');
        }
        $extType = explode('/', $file->getMimeType());
        $extType = $extType[1];
        if (in_array($extType, $this->imageTypes) === false){
            return $this->error('必须上传图片文件【png或jpeg格式】', [
                'type'  =>  $extType
            ]);
        }
        $formData[$this->imageField] = Image::instance()->upload($file, $this->imageModule);
        $insertId = $this->model->add($formData);
        $this->cache->clear(__METHOD__, $formData);
        return !$insertId ? $this->error('新增数据失败') : $this->success('新增数据成功', [
            $this->model->getPrimaryKey()       =>  $insertId,
            'data'                              =>  $formData
        ]);
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

        if ($file = $this->request->file($this->uploadField)){
            $extType = explode('/', $file->getMimeType());
            $extType = $extType[1];
            if (in_array($extType, $this->imageTypes) === false){
                return $this->error('必须上传图片文件【png或jpeg格式】', [
                    'type'  =>  $extType
                ]);
            }
            $formData[$this->imageField] = Image::instance()->upload($file, $this->imageModule);
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
                $list[$key][$this->imageField] = strpos($list[$key][$this->imageField], 'http') === 0 ? $list[$key][$this->imageField] : Http::instance()->getDomain().$list[$key][$this->imageField];
            }
        }
        return $this->success('获取数据列表成功', [
            'count' =>  $count,
            'list'  =>  $list
        ]);
    }
}