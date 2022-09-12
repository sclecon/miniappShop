<?php

namespace App\Utils;

class ArrayExpand
{
    public static function column(array $data, string $key) : array {
        return array_column($data, null, $key);
    }

    public static function getKeys(array $data, string $key) : array {
        return array_keys(self::column($data, $key));
    }

    public static function columns(array $data, string $key, string $index = '') : array {
        $newArray = [];
        foreach ($data as $datum){
            $value = $datum[$key];
            if (empty($datum[$index])){
                $newArray[$value][] = $datum;
            }else{
                $newArray[$value][$datum[$index]] = $datum;
            }
        }
        return $newArray;
    }

    public static function columnKey(array $data, string $key, string $value) : array {
        $newArray = [];
        foreach ($data as $item){
            $newArray[$item[$key]] = $item[$value];
        }
        return $newArray;
    }
}