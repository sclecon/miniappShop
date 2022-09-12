<?php
/**
 * project name Sumod
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/8/17 17:53
 */

namespace App\Utils\Model;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Di\Annotation\Inject;

class AdminListSearch
{

    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var string[]
     */
    protected $exclude = ['page', 'number'];

    public function getCondition() : array {
        $condition = [];
        $data = $this->request->all();
        foreach ($data as $field => $datum){
            if (in_array($field, $this->exclude) === false && is_string($datum)){
                $condition[] = [$field, '=', $datum];
            }
        }
        return $condition;
    }
}