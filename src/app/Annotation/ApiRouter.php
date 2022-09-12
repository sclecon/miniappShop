<?php
/**
 * project name Sumod
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/8/17 15:34
 */

namespace App\Annotation;

use Hyperf\Di\Annotation\AbstractAnnotation;
use App\Exception\Annotation\ApiRouterException;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
class ApiRouter extends AbstractAnnotation
{

    /**
     * 路由地址
     *
     * @var string
     */
    public $router;

    /**
     * 接口说明
     *
     * @var string|null
     */
    public $intro;

    /**
     * 接口请求方式
     *
     * @var string|array|null
     */
    public $method;

    /**
     * 接口中间件
     *
     * @var array
     */
    public $middleware = [];

    public function getMethod(){
        if (is_null($this->method)) return false;
        $allow = ['GET', 'POST', 'PUT', 'DELETE'];
        if (is_array($this->method)){
            $methods = [];
            foreach ($this->method as $method){
                $method = strtoupper($method);
                if (in_array($method, $allow) and in_array($method, $methods) === false){
                    $methods[] = $method;
                }
            }
            if (count($methods) === 0){
                return false;
            }
            return $methods;
        }else{
            $this->method = strtoupper($this->method);
            return in_array($this->method, $allow) ? $this->method : false;
        }
    }

    public function getIntro() : string {
        return $this->intro ?: '暂未配置说明';
    }

    public function getRouter() : string {
        return $this->router;
    }

    public function getMiddleware() : array {
        foreach ($this->middleware as $middleware){
            if (class_exists($middleware) === false){
                throw new ApiRouterException(str_replace(['{middleware}'], [$middleware], '通过"ApiRouter"注解规范的接口中间件"{middleware}"未定义'));
            }
        }
        return $this->middleware;
    }

    public function collectClass(string $className): void
    {
        if (is_string($this->router) === false){
            throw new ApiRouterException('ApiRouter注解必须配置路由');
        }
        parent::collectClass($className);
    }
}