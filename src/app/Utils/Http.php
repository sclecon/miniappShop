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
}