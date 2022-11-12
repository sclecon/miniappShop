<?php

namespace App\Utils;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;

class WechatRequest
{
    /**
     * @Inject()
     * @var
     */
    protected $request;

    public function __call($name, $arguments)
    {
        return $this->request->$name(...$arguments);
    }

    function get($key, $default = '')
    {
        return $this->request->input($key, $default);
    }

    function getContentType()
    {
        return $this->request->header('content-type', '');
    }

    function getContent()
    {
        return $this->request->getBody()
            ->getContents();
    }

    function getSchemeAndHttpHost(){
        return Http::instance()->getDomain();
    }
}