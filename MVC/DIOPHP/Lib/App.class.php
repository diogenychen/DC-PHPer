<?php
/**
 * @Author: DiogenyChen
 * @CreateTime: 2015-10-31
 * 应用程序类，执行应用过程管理
 */
class App{

    static public function run(){
        var_dump('Appclass');
        //URL调度器
        Dispatcher::dispatch();
    }
}