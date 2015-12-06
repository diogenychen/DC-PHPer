<?php
/**
 * @Author: DiogenyChen
 * @CreateTime: 2015-12-05
 * 框架执行文件
 */

//常量定义

//文件扩展
define('EXT','.class.php');

//框架相对路径
defined('DIO_PATH')     or define('DIO_PATH'   , __DIR__  . '/');
defined('LIB_PATH')     or define('LIB_PATH'   , DIO_PATH . 'Lib/');
defined('COMMON_PATH')  or define('COMMON_PATH', DIO_PATH . 'Common/');
defined('CONF_PATH')    or define('CONF_PATH'  , DIO_PATH . 'Conf/');
defined('EXTEND_PATH')  or define('EXTEND_PATH', DIO_PATH . 'Extend/');


//引入执行文件
include(LIB_PATH . 'Dio' . EXT);
Dio::init();
