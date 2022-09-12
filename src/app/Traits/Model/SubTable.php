<?php
/**
 * project name SuappPro
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/3/23 16:12
 */

namespace App\Traits\Model;

use App\Exception\Model\SubTableModelException;
use Hyperf\Database\Model\Model;

trait SubTable
{

    /**
     * @var bool
     */
    protected $setSubTable = false;

    public function add(array $data) : int {
        $this->checkSetSubTable();
        return parent::add($data);
    }

    public function update(array $attributes = [], array $options = []){
        $this->checkSetSubTable();
        return parent::update($attributes, $options);
    }

    public function subTable($value, string $type = 'id'){
        if ($this->setSubTable === true){
            return true;
        }
        $allowType = ['id'];
        if (in_array($type, $allowType) === false){
            $allow = implode('、', $allowType);
            throw new SubTableModelException('分表操作只支持'.$allow.'方式');
        } else if (strlen((string) $this->table) === 0){
            throw new SubTableModelException('分表模型必须设置数据表名称');
        }
        if ($type === 'id'){
            $this->table .= $value % 10;
        }
        $this->setSubTable = true;
    }

    protected function checkSetSubTable(){
        if ($this->setSubTable === false){
            throw new SubTableModelException('分表模型需要调用分表函数');
        }
    }
}