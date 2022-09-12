<?php
/**
 * project name Sumod
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/8/18 17:15
 */

namespace App\Middleware\Annotation;

use Hyperf\HttpServer\Router\Dispatched;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use App\Annotation\Handler\ValidatorHandler;

class ValidatorMiddleware implements MiddlewareInterface
{

    /**
     * @var ValidatorFactoryInterface
     */
    protected $validationFactory;

    /**
     * @var ValidatorHandler
     */
    protected $handler;

    /**
     * @var RequestInterface
     */
    protected $request;

    public function __construct(ValidatorHandler $handler, ValidatorFactoryInterface $validationFactory, RequestInterface $request)
    {
        $this->handler = $handler;
        $this->validationFactory = $validationFactory;
        $this->request = $request;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $dispatched = $request->getAttribute(Dispatched::class);
        if (is_null($dispatched->handler)){
            return $handler->handle($request);
        }
        $callback = $dispatched->handler->callback;
        if (is_array($callback)) {
            list($namespace, $action) = $callback;
        } else if (is_string($callback) && str_contains($callback, '@')) {
            list($namespace, $action) = explode('@', $callback);
        } else {
            return $handler->handle($request);
        }
        $this->handler->handler($namespace, $action, $this->request, $this->validationFactory);
        return $handler->handle($request);
    }
}