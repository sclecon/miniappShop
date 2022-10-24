<?php

namespace App\Event\User\Address;

class DeletedAddressEvent
{
    protected $userId;

    public function __con(int $userId){
        $this->userId = $userId;
    }
}