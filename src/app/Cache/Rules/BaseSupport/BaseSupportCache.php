<?php

namespace App\Cache\Rules\BaseSupport;

use Hyperf\Utils\Traits\StaticInstance;

class BaseSupportCache
{
    use StaticInstance;

    protected $prefix = 'c:sumod';

    protected $_prefix = 'self';

    protected function format(string $key) : string {
        if (is_null($this->_prefix)){
            throw new \Exception('必须配置缓存Prefix');
        }
        return $this->prefix.':'.$this->_prefix.':'.$key;
    }
}