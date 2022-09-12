<?php
/**
 * project name Sumod
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/8/17 17:56
 */

namespace App\Utils;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Di\Annotation\Inject;

class FormData
{
    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var string[]
     */
    protected $exclude = ['page', 'number', 'id'];

    /**
     * @param array|string $ignore
     * @return array
     */
    public function getPostData($ignore = []) : array {
        $ignore = is_string($ignore) ? [$ignore] : $ignore;
        $exclude = array_merge($this->exclude, $ignore);
        $formData = $this->request->all();
        foreach ($formData as $field => $value){
            if (in_array($field, $exclude)){
                unset($formData[$field]);
            }
        }
        return $formData;
    }
}