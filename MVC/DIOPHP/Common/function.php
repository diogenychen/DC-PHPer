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
function getC($key = '',$val = null){
    static $_config = array();
    //不传值时返回全部
    if(empty($key)){
        return $_config;
    }
    //$val为空
    if(!empty($val)){
        $_config[$key] = $val;
    }else{
        //$val不为空
        if(is_array($key)){
            //传入数组  则视为定义配置常量  后面定义的会覆盖前面定义的常量
            $_config = array_merge($_config,$key);
        }else{
            //$key是含有分隔符
            if(strpos($key,'.')){
                list($level1,$level2) = explode('.',$key);
                return empty($_config[$level1][$level2]) ? '' : $_config[$level1][$level2];
            }
            //$key是纯字符串
            return empty($_config[$key]) ? '' : $_config[$key];
        }
    }
    return true;
}

/**
 * 加载文件
 * @param string $path
 * @return boolean
 */
function import($path){
    $path = trim($path);
    if(empty($path)){
        return false;
    }
    if(is_file($path)){
        include_once($path);
        return true;
    }
    $first = substr($path,0,1);
    $str = '';
    //'*'代表加载框架文件
    if($first == '*'){
        $str = substr(DIO_PATH,0,-1);
    }
    //'@'代表加载应用文件
    if($first == '@'){
        $str = APP_PATH . getC('DEFAULT_MODULE');
    }
    $path  = str_replace('.','/',str_replace($first,$str,$path));
    $path .= EXT;var_dump($path);
    if(is_file($path)){
        include_once($path);
        return true;
    }
    return false;
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


