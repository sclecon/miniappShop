<?php
/**
 * project name Sumod
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/8/17 15:47
 */

namespace App\Annotation\Collector;

use Hyperf\Di\Annotation\AnnotationCollector;
use App\Annotation\Validator;

class ValidatorCollector extends AnnotationCollector
{
    /**
     * @var string
     */
    protected static $annotation = Validator::class;

    public static function collectMethod(string $class, string $method, string $annotation, $value): void
    {
        static::$container[$class]['_m'][$method][$annotation][] = $value;
    }

    public static function collectClass(string $class, string $annotation, $value): void
    {
        static::$container[$class]['_ct'][$annotation][] = $value;
    }

    public static function getController(string $controller, string $action) : array {
        $controllerValidator = empty(static::$container[$controller]['_ct'][self::$annotation]) ? [] : static::$container[$controller]['_ct'][self::$annotation];
        $actionValidator = empty(static::$container[$controller]['_m'][$action][self::$annotation]) ? [] : static::$container[$controller]['_m'][$action][self::$annotation];
        return self::format($controllerValidator, $actionValidator);
    }

    protected static function format(array $controller, array $action) : array {
        $format = [];
        foreach ($controller as $value){
            $format[$value->attribute] = self::toArray($value);
        }
        foreach ($action as $value){
            $format[$value->attribute] = self::toArray($value);
        }
        return self::toString($format);
    }

    protected static function toArray(Validator $validator) : array {
        return [
            'attribute' =>  $validator->attribute,
            'rule' =>  explode('|', $validator->rule),
            'intro' =>  $validator->intro ?: '暂未设置说明',
            'required' =>  $validator->required,
        ];
    }

    protected static function toString(array $array) : array {
        $stringRule = [];
        foreach ($array as $key => $value){
            if ($value['required'] === true and in_array('required', $value['rule']) === false){
                $value['rule'] = array_merge(['required'], $value['rule']);
            }
            $stringRule[$key] = implode('|', array_filter($value['rule']));
        }
        return $stringRule;
    }
}