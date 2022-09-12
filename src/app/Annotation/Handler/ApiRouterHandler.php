<?php
/**
 * project name Sumod
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/8/17 15:50
 */

namespace App\Annotation\Handler;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Di\Annotation\AnnotationCollector;
use Hyperf\HttpServer\Router\Router;
use Hyperf\Utils\ApplicationContext;
use App\Annotation\ApiRouter;
use App\Exception\Annotation\ApiRouterException;

class ApiRouterHandler
{

    /**
     * @var string
     */
    protected static $annotation = ApiRouter::class;

    /**
     * @var string[]
     */
    protected static $notAllowedMethods = ['success', 'error'];

    /**
     * @var StdoutLoggerInterface
     */
    protected static $logger;

    public static function handler(){
        echo PHP_EOL;
        echo PHP_EOL;
        echo PHP_EOL;
        $_number = 0;
        $apiRouterController = self::getControllers();
        foreach ($apiRouterController as $controller => $apiRouter){
            $controllerMethods = get_class_methods($controller);
            $apiRouterMethods = self::getControllerMethods($controller);
            $controllerRouter = $apiRouter->getRouter();
            $controllerRouter = (substr($controllerRouter, 0, 1) === '/' ? '' : '/').$controllerRouter;
            $controllerRouter = substr($controllerRouter, -1, 1) === '/' ? substr($controllerRouter, 0, -1) : $controllerRouter;
            $controllerRouterMethod = $apiRouter->getMethod();
            if ($controllerRouterMethod === false){
                throw new ApiRouterException(str_replace(['{controller}'], [$controller], '控制器"{controller}"的ApiRouter注解中未设置Method请求模式，此参数必须设置'));
            }
            $controllerRouterMiddleware = $apiRouter->getMiddleware();
            $controllerIntro = $apiRouter->intro ?: '暂未设置';
            foreach ($controllerMethods as $controllerMethod){
                if (self::checkIsAllowedControllerMethod($controllerMethod) === false) continue;
                $setRouter = $controllerRouter;
                $setMethod = $controllerRouterMethod;
                $setMiddleware = $controllerRouterMiddleware;
                $setHandler = str_replace(['{controller}', '{method}'], [$controller, $controllerMethod], '{controller}@{method}');
                if (in_array($controllerMethod, array_keys($apiRouterMethods))){
                    $controllerMethodApiRouter = $apiRouterMethods[$controllerMethod];
                    $_router = $controllerMethodApiRouter->getRouter();
                    $setRouter = substr($_router, 0, 1) === '/' ? $_router : str_replace(['{pre}', '{router}'], [$setRouter, $_router], '{pre}/{router}');
                    $methodResponse = $controllerMethodApiRouter->getMethod();
                    if ($methodResponse !== false){
                        $setMethod = $methodResponse;
                    }
                    $intro = $controllerMethodApiRouter->intro ?: '暂未设置说明';
                    $setMiddleware = array_merge($setMiddleware, $controllerMethodApiRouter->getMiddleware());
                }else{
                    $intro = '暂未设置说明';
                    $setRouter = str_replace(['{pre}', '{router}'], [$setRouter, $controllerMethod], '{pre}/{router}');
                }
                $_number += 1;
                $tip = str_replace(
                    ['{router}', '{handler}', '{method}', '{middleware}', '{intro}', '{controllerIntro}', '{_number}'],
                    [$setRouter, $setHandler, implode(',', (array) $setMethod), implode(',', $setMiddleware), $intro, $controllerIntro, $_number],
                    '[{_number}] [{method}]  {router} => {handler} middleware=[{middleware}] intro=[{controllerIntro}]{intro}'
                );
                self::output($tip, 'INFO');
                Router::addRoute($setMethod, $setRouter, $setHandler, ['middleware'=>$setMiddleware]);
            }
        }
        echo PHP_EOL;
        echo PHP_EOL;
        echo PHP_EOL;
    }

    protected static function getControllers() : array {
        return AnnotationCollector::getClassesByAnnotation(self::$annotation);
    }

    protected static function getMethods() : array {
        return AnnotationCollector::getMethodsByAnnotation(self::$annotation);
    }

    protected static function getControllerMethods(string $controller) : array {
        $methods = self::getMethods();
        $controllerMethods = [];
        foreach ($methods as $method){
            if ($method['class'] === $controller){
                $controllerMethods[$method['method']] = $method['annotation'];
            }
        }
        return $controllerMethods;
    }

    protected static function checkIsAllowedControllerMethod(string $method) : bool {
        return (in_array($method, self::$notAllowedMethods) === false and substr($method, 0, 2) !== '__');
    }

    protected static function output(string $message, string $type = 'INFO'){
        if (is_null(self::$logger)){
            self::$logger = ApplicationContext::getContainer()->get(StdoutLoggerInterface::class);
        }
        $message = str_replace(['{msg}'], [$message], 'Router {msg}');
        self::$logger->info($message);
    }
}