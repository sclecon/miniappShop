<?php

namespace App\Utils;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\Traits\StaticInstance;

class Http
{
    use StaticInstance;

    /**
     * @Inject()
     * @var RequestInterface
     */
    protected $request;

    public function getDomain() : string {
        return $this->getScheme().'://'.$this->getHost();
    }

    public function getHost() : string {
        return $this->request->header('host');
    }

    public function getScheme() : string {
        $headers = $this->request->getHeaders();
        if (isset($headers['x-scheme'])) {
            return $headers['x-scheme'][0];
        }
        if (isset($headers['x-forwarded-proto'])) {
            return $headers['x-forwarded-proto'][0];
        }
        $protocol = ($this->request->getUri()->getScheme() == 'https') ? 'https' : 'http';
        return $protocol;
    }

    public function image(string $url) : string {
        return strpos($url, 'http') === 0 ? $url : Http::instance()->getDomain().$url;
    }

    public function getClientIp() : string {
        $res = $this->request->getServerParams();
        if(isset($res['http_client_ip'])){
            return $res['http_client_ip'];
        }elseif(isset($res['http_x_real_ip'])){
            return $res['http_x_real_ip'];
        }elseif(isset($res['http_x_forwarded_for'])){
            $arr = explode(',',$res['http_x_forwarded_for']);
            return $arr[0];
        }else{
            return $res['remote_addr'];
        }
    }

    public function getRequestUserName() : string {
        return substr(md5($this->getClientIp()), 12, 8);
    }
}