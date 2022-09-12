<?php
/**
 * project name SuappPro
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/3/24 11:45
 */

namespace App\Traits\Model;

trait Utils
{
    public function getPrimaryKey() : string {
        return $this->primaryKey;
    }

    public function add(array $data) : int {
        $class = static::class;
        $model = new $class();
        $model->table = $this->table;
        foreach ($data as $field => $datum){
            $model->$field = $datum;
        }
        $model->save();
        $primaryKey = $model->getPrimaryKey();
        $primaryKey = $model->$primaryKey;
        unset($model);
        return $primaryKey;
    }

    public function getTableKey(string $column) : string {
        return $this->getTable().'.'.$column;
    }
}