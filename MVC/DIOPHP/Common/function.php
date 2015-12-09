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
 * 加载文件
 */
function import(){
    //
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

    if(!is_dir($dir) || in_array($dir,array('.','..','./','../'))){
        return $type ? $filePath : false;
    }

    //获取目录下的所有文件及目录名
    $files = filesInDir($dir);
    if(empty($files)){
        return $type ? $filePath : false;
    }
    //查找文件
    $files = arrayMultiToSingle($files);
    $tmp = array();
    foreach($files as $val){
        if(strpos($val,$filename)){
            $tmp[strlen($val)] = $val;
        }
    }
    if(empty($tmp)){
        return $type ? $filePath : false;
    }
    ksort($tmp);
    return array_shift($tmp);
}

/**
 * 获取目录下的所有文件名 包括子目录 指定后缀
 * @param string $dir
 * @return array
 */
function filesInDir($dir,$ext = ''){
    $dir = trim($dir);
    $dir = trim($dir,'/');
    $allFiles = array();
    if(is_dir($dir) && !in_array($dir,array('.','..','./','../'))){
        $files = scandir($dir);
        foreach($files as $val){
            if(in_array($val,array('.','..'))){
                continue;
            }
            $path = $dir. '/' . $val;
            if(is_dir($path)){
                //当时目录时 递归获取文件
                $child = filesInDir($path);
                if($child){
                    $allFiles[$val] = $child;
                }
            }else{
                if($ext != ''){
                    if(pathinfo($path,PATHINFO_EXTENSION) == $ext){
                        $allFiles[] = $path;
                    }
                }else{
                    $allFiles[] = $path;
                }
            }
        }
        return $allFiles;
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


