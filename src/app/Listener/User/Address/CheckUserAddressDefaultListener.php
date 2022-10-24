<?php

namespace App\Listener\User\Address;

use App\Event\User\Address\DeletedAddressEvent;
use App\Services\UserAddressService;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;

/**
 * @Listener()
 */
class CheckUserAddressDefaultListener implements ListenerInterface
{
    public function listen(): array
    {
        return [DeletedAddressEvent::class];
    }

    public function process(object $event)
    {
        UserAddressService::instance()->checkUserDefault($event->userId);
    }
}