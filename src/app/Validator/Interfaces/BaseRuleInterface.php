<?php
/**
 * project name Sumod
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/8/17 17:02
 */

namespace App\Validator\Interfaces;

use Hyperf\Validation\Validator;

interface BaseRuleInterface
{
    const PASSES_NAME = 'passes';
    const MESSAGE_NAME = 'message';

    public function passes($attribute, $value, $parameters, Validator $validator) : bool ;

    public function message($message, $attribute, $rule, $parameters, Validator $validator) : string ;
}