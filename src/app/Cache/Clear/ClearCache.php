<?php

namespace App\Cache\Clear;

use App\Cache\Rules\BaseSupport\BaseSupportCache;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;

class ClearCache extends BaseSupportCache
{
    /**
     * @Inject()
     * @var Redis
     */
    protected $redis;

    public function clear(string $key = ''){
        if (strlen($key)){
            return $this->one($key);
        }
        return $this->all();
    }

    protected function one(string $key) : int {
        return $this->redis->del($key);
    }

    protected function all(){
        $keys = $this->getKeys();
        foreach ($keys as $key){
            $this->redis->del($key);
        }
        return true;
    }

    protected function getKeys() : array {
        return $this->redis->keys($this->prefix.':*');
    }
}