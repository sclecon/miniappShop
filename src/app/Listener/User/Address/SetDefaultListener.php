<?php

namespace App\Listener\User\Address;

use App\Event\User\Address\AddAddressEvent;
use App\Services\UserAddressService;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;

/**
 * @Listener()
 */
class SetDefaultListener implements ListenerInterface
{
    public function listen(): array
    {
        return [AddAddressEvent::class];
    }

    public function process(object $event)
    {
        if ($event->default){
            UserAddressService::instance()->clearDefaultAddress($event->userId);
        }
    }
}