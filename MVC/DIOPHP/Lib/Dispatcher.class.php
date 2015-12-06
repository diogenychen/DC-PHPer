<?php
/**
 * @Author: DiogenyChen
 * @CreateTime: 2015-10-31
 * url调度器
 */
class Dispatcher{

    static public function dispatch(){
        var_dump('dispatchclass');
        //$pathInfo = empty($_SERVER['PATH_INFO']) ? '' : $_SERVER['PATH_INFO'];
        $module     = empty($_GET['m']) ?  '' : $_GET['m'];
        $controller = empty($_GET['c']) ?  '' : $_GET['c'] . 'Controller';
        $action     = empty($_GET['a']) ?  '' : $_GET['a'];

        $handler    = new $controller();
        $handler->$action();
    }
}