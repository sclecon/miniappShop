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

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->hasHeader($this->authentication) === false){
            throw new AuthenticationException('Admin Authentication parameter must be passed');
        }
        $adminer = $this->portUser->decode($request->getHeader($this->authentication)[0]);
        $request = $request->withAttribute('adminer', $adminer);
        return $handler->handle($request);
    }
}