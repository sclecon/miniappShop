<?php

namespace App\Middleware\Admin;

use App\Exception\Middleware\AuthenticationException;
use App\Utils\Sign\PortUser;
use Hyperf\Di\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthenticationMiddleware implements MiddlewareInterface
{
    /**
     * @var string
     */
    protected $authentication = 'Authentication';

    /**
     * @Inject()
     * @var PortUser
     */
    protected $portUser;

    /**
     * @var bool
     */
    protected $mandatory = true;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->hasHeader($this->authentication) === false){
            if ($this->mandatory){
                throw new AuthenticationException('Admin Authentication parameter must be passed');
            }
            var_dump('Admin Authentication parameter must be passed');
            return $handler->handle($request);
        }
        $adminer = $this->portUser->decode($request->getHeader($this->authentication)[0]);
        $request = $request->withAttribute('adminer', $adminer);
        return $handler->handle($request);
    }
}