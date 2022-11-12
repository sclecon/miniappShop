<?php

namespace App\Middleware\User;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Exception\Middleware\AuthenticationException;
use Hyperf\Di\Annotation\Inject;
use App\Utils\Sign\PortUser;

class AuthenticationMiddleware implements MiddlewareInterface
{
    /**
     * @var string
     */
    protected $authentication = 'Authentication';

    /**
     * @Inject
     * @var PortUser
     */
    protected $portUser;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->hasHeader($this->authentication) === false){
            var_dump('User Authentication parameter must be passed');
            // throw new AuthenticationException('User Authentication parameter must be passed');
        }
        $user = $this->portUser->decode($request->getHeader($this->authentication)[0]);
        $request = $request->withAttribute('user_id', $user['user_id']);
        return $handler->handle($request);
    }
}