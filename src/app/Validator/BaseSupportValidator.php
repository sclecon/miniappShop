<?php
/**
 * project name Sumod
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/8/17 16:56
 */

namespace App\Validator;

use Hyperf\Utils\ApplicationContext;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use App\Exception\ValidatorException;
use App\Validator\Interfaces\BaseRuleInterface;
use App\Validator\Rule\PhoneRule;

class BaseSupportValidator
{
    /**
     * @var array
     */
    protected static $extends = [];

    protected static function getValidator() {
        static $validator = null;
        if (is_null($validator)) {
            $container = ApplicationContext::getContainer();
            $validator = $container->get(ValidatorFactoryInterface::class);
            self::initExtends();
            self::registerExtends($validator, self::$extends);
        }
        return $validator;
    }

    protected static function initExtends(){
        self::$extends = [
            PhoneRule::NAME =>  new PhoneRule,
        ];
    }

    protected static function registerExtends(ValidatorFactoryInterface $validator, array $extends){
        foreach ($extends as $key => $extend){
            if ($extend instanceof BaseRuleInterface){
                $validator->extend($key, function (...$args) use ($extend) {
                    return call_user_func_array([$extend, BaseRuleInterface::PASSES_NAME], $args);
                });
                $validator->replacer($key, function (...$args) use ($extend) {
                    return call_user_func_array([$extend, BaseRuleInterface::MESSAGE_NAME], $args);
                });
            }
        }
    }

    public static function inspect(array $data, array $rules, array $messages = [], bool $firstError = true) : array {
        $validator = self::getValidator();
        if (empty($messages)){
            $messages = self::messages();
        }
        $validator = $validator->make($data, $rules, $messages);
        if ($validator->fails()){
            throw new ValidatorException($validator->errors()->first());
        }
        return $validator->validated();
    }

    protected static function messages() : array {
        return [];
    }
}