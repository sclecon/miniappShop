<?php

namespace App\Controller\Admin;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\Admin\Base\BaseCurd;
use App\Model\ShopBannerModel;
use App\Utils\Image;

/**
 * @ApiRouter(router="admin/shop/banner", method="get", intro="首页Banner轮播图")
 */
class ShopBanner extends BaseCurd
{
    public function __construct()
    {
        $this->model = new ShopBannerModel();
        parent::__construct();
    }

    /**
     * @ApiRouter(router="add", intro="新增轮播图", method="PUT")
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
}