<?php
/**
 * project name Sumod
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/8/18 16:35
 */

namespace App\Traits\Controller;

use Hyperf\HttpServer\Contract\ResponseInterface;

trait Response
{
    public function error(string $msg, array $data = [], array $cookie = [], int $code = 5000, int $httpStatusCode = 200) {
        return \App\Utils\Response::instance()->error($msg, $code, $data, $cookie, $httpStatusCode);
    }

    public function success(string $msg, array $data = [], array $cookie = [], int $code = 200){
        return \App\Utils\Response::instance()->success($msg, $data, $code, $cookie, $code);
    }
}