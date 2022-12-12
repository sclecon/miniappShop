<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\Admin\Base\BaseCurd;
use App\Middleware\Admin\AuthenticationMiddleware;

/**
 * @ApiRouter(router="admin/config", method="get", intro="配置管理", middleware={AuthenticationMiddleware::class})
 */
class Config extends BaseCurd
{
    /**
     * @ApiRouter(router="delete", intro="数据删除", method="DELETE")
     * @Validator(attribute="id", rule="integer", required=true)
     */
    public function delete(){
        $primaryKey = $this->request->input('id');
        $data = $this->model
            ->where($this->model->getPrimaryKey(), $primaryKey)
            ->first();
        if (!$data){
            return $this->error('数据已删除或不存在');
        }elseif ($data->system){
            return $this->error('系统配置不允许删除');
        }
        $response = $this->model->where($this->model->getPrimaryKey(), $primaryKey)->delete();
        $this->cache->clear(__METHOD__, $data->toArray());
        return !$response ? $this->error('删除数据失败') : $this->success('删除数据成功');
    }
}