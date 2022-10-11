<?php
/**
 * project name Sumod
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/8/17 16:49
 */

namespace App\Annotation\Handler;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use App\Annotation\Collector\ValidatorCollector;
use App\Annotation\Validator;
use App\Validator\BaseSupportValidator;

class ValidatorHandler
{

    /**
     * @var string
     */
    protected $annotation = Validator::class;

    public function handler(string $controller, string $action, RequestInterface $request, ValidatorFactoryInterface $validatorFactory){
        $methodRule = ValidatorCollector::getController($controller, $action);
        if (!$methodRule){
            return false;
        }
        var_dump(array_merge($request->all(), $request->getUploadedFiles()));
        return BaseSupportValidator::inspect(array_merge($request->all(), $request->getUploadedFiles()), $methodRule);
    }
}