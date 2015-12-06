<?php
/**
 * @Author: DiogenyChen
 * @Createtime: 2015-10-31
 * 基础函数库
 */

/**
 * 获取配置文件内容
 * 设置配置项
 * @param string $key
 * @param mixed $val
 * @return mixed
 */
function getC($key,$val){
    //TODO
}

/**
 * 根据文件名在指定目录下查找 是否存在
 * @param string $dir
 * @param string $filename
 * @param int $type  返回类型 1=返回文件路径，0=返回bool类型
 * @return mixed
 */
function findFile($dir,$filename,$type = 1){
    $dir      = trim($dir);
    $filename = trim($filename);
    $type     = intval($type);

    $filePath = '';

    if(is_dir($dir)){
        return $type ? $filePath : false;
    }

    //获取目录下的所有文件及目录名
    $files = filesInDir($dir);
    if(empty($files)){
        return $type ? $filePath : false;
    }
    //查找文件
    $tmp = array();
    foreach($files as $val){
        if(strpos($val,$filename)){
            $tmp[strlen($val)] = $val;
        }
    }
    if(empty($tmp)){
        return $type ? $filePath : false;
    }
    sort($tmp);
    return $tmp[0];
}

/**
 * 获取目录下的所有文件名 包括子目录
 * @param string $dir
 * @return array
 */
function filesInDir($dir){
    $allFiles = array();
    if(is_dir($dir)){
        $files = scandir($dir);
        foreach($files as $val){
            if(is_dir($val)){
                $child = filesInDir($val);
                foreach($child as $ck => $cv){
                    $child[$ck] = $val . '/' . $cv;
                }
                $allFiles[] = $child;
            }else{
                $allFiles[] = $val;
            }
        }
        $tmp = arrayMultiToSingle($allFiles);
        if($tmp){
            return $tmp;
        }
    }
    return false;
}

/**
 * 功能:将多维数组合并为一位数组
 * @param array $array   需要合并的数组
 * @param boolean $clearRepeated  是否清除并后的数组中得重复值
 * @return mixed
 */
function arrayMultiToSingle($array,$clearRepeated=false){
    if(!isset($array)||!is_array($array)||empty($array)){
        return false;
    }
    if(!in_array($clearRepeated,array('true','false',''))){
        return false;
    }
    static $result_array=array();
    foreach($array as $value){
        if(is_array($value)){
            arrayMultiToSingle($value);
        }else{
            $result_array[]=$value;
        }
    }
    if($clearRepeated){
        $result_array=array_unique($result_array);
    }
    return $result_array;
}


