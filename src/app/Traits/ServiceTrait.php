<?php
/**
 * project name SuappPro
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/3/8 09:45
 */

namespace App\Traits;

use Hyperf\Redis\Redis;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Traits\StaticInstance;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\SimpleCache\CacheInterface;
use App\Exception\Service\ServiceException;
use App\Model\BaseSupport\BaseSupportModel;

trait ServiceTrait
{

    /**
     * @var string|BaseSupportModel|null
     */
    protected $model;

    use StaticInstance;

    protected function getModel() : BaseSupportModel {
        if (is_null($this->model)){
            throw new ServiceException('服务中获取model之前必须指定model');
        }
        if (is_string($this->model)){
            $this->model = new $this->model();
        }
        return $this->model;
    }

    protected function getEventDispatcher(){
        return ApplicationContext::getContainer()->get(EventDispatcherInterface::class);
    }

    protected function getCacheInterface(){
        return ApplicationContext::getContainer()->get(CacheInterface::class);
    }

    protected function getRedisInterface(){
        return ApplicationContext::getContainer()->get(Redis::class);
    }
}