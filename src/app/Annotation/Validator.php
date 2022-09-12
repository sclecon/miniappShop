<?php
/**
 * project name Sumod
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/8/17 15:46
 */

namespace App\Annotation;

use Hyperf\Di\Annotation\AbstractAnnotation;
use App\Annotation\Collector\ValidatorCollector;

/**
 * @Annotation
 * @Target({"METHOD", "CLASS"})
 */
class Validator extends AbstractAnnotation
{

    /**
     * 参数名
     *
     * @var string
     */
    public $attribute;

    /**
     * 参数验证规则
     *
     * @var string|null
     */
    public $rule;

    /**
     * 参数说明
     *
     * @var string
     */
    public $intro;

    /**
     * 是否必传此参数
     *
     * @var bool
     */
    public $required = false;

    public function collectMethod(string $className, ?string $target): void
    {
        ValidatorCollector::collectMethod($className, $target, static::class, $this);
    }

    public function collectClass(string $className): void
    {
        ValidatorCollector::collectClass($className, static::class, $this);
    }

}