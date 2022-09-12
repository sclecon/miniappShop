<?php
/**
 * project name Sumod
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/8/17 17:06
 */

namespace App\Validator\Rule;

use App\Validator\Interfaces\BaseRuleInterface;
use Hyperf\Validation\Validator;

class PhoneRule implements BaseRuleInterface
{

    const NAME = 'phone';

    /**
     * @var string
     */
    protected $message = '{attribute} 不是一个有效的手机号';

    public function passes($attribute, $value, $parameters, Validator $validator): bool
    {
        return preg_match('/^1\d{10}$/', $value);
    }

    public function message($message, $attribute, $rule, $parameters, Validator $validator): string
    {
        return str_replace(['{attribute}'], [$attribute], $this->message);
    }
}