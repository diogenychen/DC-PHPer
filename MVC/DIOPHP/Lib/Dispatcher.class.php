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
        unset($_GET['m']);unset($_GET['c']);unset($_GET['a']);

        defined('MODULE_NAME')     or define('MODULE_NAME',$module);
        defined('CONTROLLER_NAME') or define('CONTROLLER_NAME',$module);
        defined('ACTION_NAME')     or define('ACTION_NAME',$module);

        import('@.Controller.' . $controller);
        $handler    = new $controller();
        $handler->$action();



    }
}