<?php
/**
 * @Author: DiogenyChen
 * @CreateTime: 2015-11-25
 * mysqli数据库操作类
 */
class MySqli {
    /**
     * 实例化对象
     */
    static $instance = null;

    /**
     * 内部数据链接对象
     */
    protected $conn;

    /**
     * 最后执行的SQL语句
     */
    protected $lastSql = '';

    /**
     * 执行SQL语句后的结果集
     */
    protected $queryRes = null;

    /**
     * 数据库链接项
     */
    protected $config = array(
        'DB_TYPE'       => 'mysql',
        'DB_HOST'       => '127.0.0.1',
        'DB_NAME'       => 'test',
        'DB_USER'       => 'root',
        'DB_PWD'        => '',
        'DB_PORT'       => '3306',
        'DB_PREFIX'     => '',
        'DB_CHARSET'    => 'utf8',
        'DB_PERSISTENT' => false
    );

    /**
     * 构造器
     */
    public function __construct($config){
        if(!function_exists('mysql_connect')){
            die('PHP do not support mysql database');
        }
        if(empty($config)){
            die('config is empty');
        }
        $this->config = array_merge($this->config,$config);
        $this->connect();
    }




}