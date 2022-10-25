<?php

namespace App\Event\User\Address;

class AddAddressEvent
{

    public $userId;
    public $name;
    public $province;
    public $city;
    public $area;
    public $detail;
    public $phone;
    public $default;


    public function __construct(int $userId, string $name, string $province, string $city, string $area, string $detail, int $phone, int $default){
        $this->userId = $userId;
        $this->name = $name;
        $this->province = $province;
        $this->city = $city;
        $this->area = $area;
        $this->detail = $detail;
        $this->phone = $phone;
        $this->default = $default;
    }
}