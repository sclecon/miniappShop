<?php

namespace App\Controller\Port;

use App\Annotation\ApiRouter;
use App\Annotation\Validator;
use App\Controller\BaseSupport\BaseSupportController;
use App\Services\UserAddressService;
use App\Middleware\User\AuthenticationMiddleware;

/**
 * @ApiRouter(router="port/user/address", method="get", intro="用户收货地址", middleware={AuthenticationMiddleware::class})
 */
class UserAddress extends BaseSupportController
{
    /**
     * @ApiRouter(router="add", method="put", intro="添加收货地址")
     * @Validator(attribute="name", required=true, rule="string", intro="收货人姓名")
     * @Validator(attribute="province", required=true, rule="string", intro="省份")
     * @Validator(attribute="city", required=true, rule="string", intro="城市")
     * @Validator(attribute="area", required=true, rule="string", intro="区县")
     * @Validator(attribute="detail", required=true, rule="string", intro="地址详情")
     * @Validator(attribute="phone", required=true, rule="string", intro="联系电话")
     * @Validator(attribute="default", required=true, rule="integer", intro="是否默认")
     */
    public function add(){
        $userId = $this->getAuthUserId();
        $name = $this->request->input('name');
        $province = $this->request->input('province');
        $city = $this->request->input('city');
        $area = $this->request->input('area');
        $detail = $this->request->input('detail');
        $phone = (int) $this->request->input('phone');
        $default = (int) $this->request->input('default');
        $addressId = UserAddressService::instance()->add($userId, $name, $province, $city, $area, $detail, $phone, $default);
        return $this->success('添加收货地址成功', ['address_id'=>$addressId]);
    }

    /**
     * @ApiRouter(router="find", method="get", intro="查询收货地址")
     * @Validator(attribute="address_id", required=true, rule="integer", intro="收货地址ID")
     */
    public function find(){
        $userId = $this->getAuthUserId();
        $addressId = (int) $this->request->input('address_id');
        $address = UserAddressService::instance()->detail($userId, $addressId);
        return $this->success('获取收获地址成功', $address);
    }

    /**
     * @ApiRouter(router="save", method="post", intro="收货地址保存修改")
     * @Validator(attribute="address_id", required=true, rule="integer", intro="收货地址ID")
     * @Validator(attribute="name", required=true, rule="string", intro="收货人姓名")
     * @Validator(attribute="province", required=true, rule="string", intro="省份")
     * @Validator(attribute="city", required=true, rule="string", intro="城市")
     * @Validator(attribute="area", required=true, rule="string", intro="区县")
     * @Validator(attribute="detail", required=true, rule="string", intro="地址详情")
     * @Validator(attribute="phone", required=true, rule="string", intro="联系电话")
     * @Validator(attribute="default", required=true, rule="integer", intro="是否默认")
     */
    public function save(){
        $userId = $this->getAuthUserId();
        $name = $this->request->input('name');
        $province = $this->request->input('province');
        $city = $this->request->input('city');
        $area = $this->request->input('area');
        $detail = $this->request->input('detail');
        $phone = (int) $this->request->input('phone');
        $default = (int) $this->request->input('default');
        $addressId = (int) $this->request->input('address_id');
        $formData = UserAddressService::instance()->save($userId, $name, $province, $city, $area, $detail, $phone, $default, $addressId);
        return $this->success('修改收货地址成功', $formData);
    }

    /**
     * @ApiRouter(router="all", method="get", intro="获取所有收货地址")
     */
    public function list(){
        $userId = $this->getAuthUserId();
        return $this->success('获取所有收货地址成功', ['list'=>UserAddressService::instance()->list($userId)]);
    }

    /**
     * @ApiRouter(router="delete", method="delete", intro="删除收货地址")
     * @Validator(attribute="address_id", required=true, rule="integer", intro="收货地址ID")
     */
    public function del(){
        $userId = $this->getAuthUserId();
        $addressId = (int) $this->request->input('address_id');
        UserAddressService::instance()->delete($userId, $addressId);
        return $this->success('删除收货地址成功');
    }

    /**
     * @ApiRouter(router="default", method="get", intro="获取默认收货地址")
     */
    public function default(){
        $userId = $this->getAuthUserId();
        $address = UserAddressService::instance()->detail($userId, 0, 1);
        return $this->success('获取默认收货地址成功', $address);
    }
}