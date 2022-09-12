<?php
/**
 * project name Sumod
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/8/18 16:30
 */

namespace App\Utils;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpMessage\Cookie\Cookie;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Utils\Traits\StaticInstance;
use Psr\Http\Message\ResponseInterface as Psr7ResponseInterface;

class Response
{

    /**
     * @Inject
     * @var ResponseInterface
     */
    protected $responseInterface;

    use StaticInstance;

    public function error(string $msg, int $code = 500, array $data = [], array $cookie = [], int $httpStatus = 0) : Psr7ResponseInterface {
        $code = $code === 0 ? 500 : $code;
        $httpStatus = $httpStatus ?: $code;
        return $this->output($this->response($msg, $code, $data), $cookie, $httpStatus);
    }

    public function success(string $msg, array $data = [], int $code = 200, array $cookie = [], int $httpStatus = 200) : Psr7ResponseInterface {
        $httpStatus = $httpStatus ?: $code;
        return $this->output($this->response($msg, $code, $data), $cookie, $httpStatus);
    }

    protected function response(string $msg, int $code, array $data) : array {
        $response = ['code'=>$code, 'msg'=>$msg];
        if ($data){
            $response['data'] = $data;
        }
        return $response;
    }

    protected function output(array $data, array $cookie, int $httpStatus = 500) : Psr7ResponseInterface {
        foreach ($cookie as $key => $value){
            $this->responseInterface = $this->responseInterface->withCookie(new Cookie($key, $value));
        }
        return $this->responseInterface->json($data)->withStatus($httpStatus);
    }
}