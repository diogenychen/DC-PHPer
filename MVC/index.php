<?php
/**
 * @Author: DiogenyChen
 * @CreateTime: 2015-10-31
 * 框架入口
 */

//相对主路径
define('ROOT',str_replace('\\','/',__DIR__) . '/');

//应用路口
define('APP_PATH',ROOT . 'Application/');

//扩展类文件夹
define('COMPONENT_PATH',APP_PATH . 'Component/');

//引入框架
include(ROOT . 'DIOPHP/Dio.php');
