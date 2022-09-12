<?php
/**
 * project name Sumod
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/8/17 17:55
 */

namespace App\Utils\Cache;

use Hyperf\Cache\Exception\CacheException;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Traits\StaticInstance;

class CurdCache
{
    use StaticInstance;

    /**
     * @var object
     */
    protected $driver;

    /**
     * @var array
     */
    protected $rule = [];

    public function setDriver(string $driver) : CurdCache
    {
        $this->driver = ApplicationContext::getContainer()->get($driver);
        return $this;
    }

    public function setRule(string $method, string $run, $args = '') : CurdCache {
        if (in_array($run, get_class_methods($this->driver)) === false){
            throw new CacheException(str_replace('{run}', $run, '{run}方法未定义'));
        }
        $this->rule[$method][$run] = is_array($args) ? $args : ($args ? [$args] : []);
        return $this;
    }

    public function clear(string $method, array $data) : bool {
        $method = explode('::', $method);
        $method = end($method);
        if (empty($this->rule[$method]) === false){
            foreach ($this->rule[$method] as $method => $rules){

                $args = [];
                if ($rules){
                    foreach ($rules as $rule){
                        $args[] = empty($data[$rule]) ? '' : $data[$rule];
                    }
                }
                call_user_func_array([$this->driver, $method], $args);
            }
        }
        return true;
    }
}