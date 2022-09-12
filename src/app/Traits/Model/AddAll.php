<?php
/**
 * project name SuappPro
 *
 * author sclecon
 * email 27941662@qq.com
 * datetime 2022/3/24 11:25
 */

namespace App\Traits\Model;

use Hyperf\DbConnection\Db;

trait AddAll
{
    public function addAll(array $data){
        $sql = 'INSERT INTO `{table}` (`{keys}`) VALUES {values};';
        $values = $keys = '';
        foreach ($data as $datum){
            if (empty($datum['created_time'])){
                $datum['created_time'] = time();
            }
            if (empty($datum['updated_time'])){
                $datum['updated_time'] = time();
            }
            $keys = $keys ?: implode('`,`', array_keys($datum));
            $values .= ($values ? ',' : '').str_replace('{values}', implode("','", array_values($datum)), "('{values}')");
        }
        $sql = str_replace(['{table}', '{keys}', '{values}'], [$this->getTable(), $keys, $values], $sql);
        return Db::insert($sql);
    }
}