<?php
/**
 * @Author: DiogenyChen
 * @CreateTime: 2015-10-31
 * 入口调用类
 */
class Dio{

    /**
     * 初始化
     */
    static public function init(){
        //注册自动加载函数
        spl_autoload_register('Dio::autoload');
        //加载配置文件
        include(CONF_PATH . 'config.php');
        //加载常用函数
        include(COMMON_PATH . 'function.php');

        //执行
        App::run();
    }

    /**
     * 自动加载函数
     */
    public static function autoload($className){
        //检查框架内置扩展类 Extend文件夹下
        $filePath = EXTEND_PATH . $className . EXT;
        if(file_exists($filePath)){
            include($filePath);
        }elseif($filePath = findFile(EXTEND_PATH,$className . EXT)){
            include($filePath);
        }elseif(($filePath = COMPONENT_PATH . $className . EXT) && file_exists($filePath)){
            //检查应用模块下的扩展文件类 Applicatioin下的Componnet文件夹下
            include($filePath);
        }elseif($filePath = findFile(EXTEND_PATH,$className . EXT)){
            include($filePath);
        }elseif($filePath = findFile(LIB_PATH,$className . EXT)){
            include($filePath);
        }elseif($filePath = findFile(APP_PATH . 'Home/Controller',$className . EXT)){var_dump(1);
            include($filePath);
        }
        return true;
    }










}