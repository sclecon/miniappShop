<?php

namespace App\Event\User\Address;

class DeletedAddressEvent
{
    public $userId;

    public function __con(int $userId){
        $this->userId = $userId;
    }
}