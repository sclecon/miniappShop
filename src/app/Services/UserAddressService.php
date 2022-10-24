<?php
/**
 * project name miniappShop
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/10/24 17:55
 */

namespace App\Services;

use App\Event\User\Address\AddAddressEvent;
use App\Exception\Service\UserAddressServiceException;
use App\Model\UserAddressModel;
use App\Services\BaseSupport\BaseSupportService;

class UserAddressService extends BaseSupportService
{
    protected $model = UserAddressModel::class;

    public function add(int $userId, string $name, string $province, string $city, string $area, string $detail, int $phone, int $default) : int {
        $this->getEventDispatcher()->dispatch(new AddAddressEvent($userId, $name, $province, $city, $area, $detail, $phone, $default));
        return $this->getModel()->add([
            'user_id'   =>  $userId,
            'default'   =>  $default,
            'name'      =>  $name,
            'province'  =>  $province,
            'city'      =>  $city,
            'area'      =>  $area,
            'detail'    =>  $detail,
            'phone'     =>  $phone,
        ]);
    }

    public function clearDefaultAddress(int $userId) : int {
        return $this->getModel()
            ->where('user_id', $userId)
            ->update([
                'default'   =>  0
            ]);
    }

    public function detail(int $userId, int $addressId = 0, int $default = 0){
        if (!$default && $addressId){
            throw new UserAddressServiceException('获取收货地址详情必须传递出一个收货地址凭证');
        }
        $address = $this->getModel()
            ->where('user_id', $userId);
        if ($addressId){
            $address = $address->where('address_id', $addressId);
        }
        if ($default){
            $address = $address->where('default', 1);
        }
        $address = $address->first();
        if (!$address){
            throw new UserAddressServiceException($default ? '暂无默认收货地址' : '收货地址不存在');
        }
        $address = $address->toArray();
        return $this->format($address);
    }

    public function save(int $userId, string $name, string $province, string $city, string $area, string $detail, int $phone, int $default, int $addressId) : array {
        $this->getEventDispatcher()->dispatch(new AddAddressEvent($userId, $name, $province, $city, $area, $detail, $phone, $default));
        $newAddressData = [
            'default'   =>  $default,
            'name'      =>  $name,
            'province'  =>  $province,
            'city'      =>  $city,
            'area'      =>  $area,
            'detail'    =>  $detail,
            'phone'     =>  $phone,
        ];
        $this->getModel()
            ->where('user_id', $userId)
            ->where('address_id', $addressId)
            ->update($newAddressData);
        return $newAddressData;
    }

    public function delete(int $userId, int $addressId) : bool {
        $address = $this->getModel()
            ->where('user_id', $userId)
            ->where('address_id', $addressId)
            ->first();
        if (!$address){
            throw new UserAddressServiceException('收货地址不存在');
        }
        $address->delete();
        return true;
    }

    public function checkUserDefault(int $userId){
        $list = $this->list($userId);
        $defaultId = 0;
        foreach ($list as $address){
            if ($address['default']){
                $defaultId = $address['address_id'];
                break;
            }
        }
        if (!$defaultId && count($list)){
            $this->getModel()->where('address_id', $userId)->update(['default'=>1]);
        }
        return true;
    }

    public function list(int $userId) : array {
        $list = $this->getModel()
            ->where('user_id', $userId)
            ->orderByDesc('default')
            ->orderByDesc('address_id')
            ->get()->toArray();
        foreach ($list as $key => $address){
            $list[$key] = $this->format($address);
        }
        return $list;
    }



    protected function format(array $address) : array {
        $address['detail_message'] = $address['province'].$address['city'].$address['area'].$address['detail'];
        return $address;
    }
}